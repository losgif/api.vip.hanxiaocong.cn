<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\UserOauth;
use App\Models\User;
use DB;
use App\Services\Sms;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Registered;
use App\Rules\VerifyCode;

/**
 * 认证类
 */
class OauthController extends Controller
{
    use Sms;
    use AuthenticatesUsers;

    public $name;

    /**
     * 设置名称字段
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    /**
     * 登录处理函数
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->failed($validator->errors());
            }

            $this->name = $request->name;

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if (method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->failed('锁定登陆');
            }

            if ($this->attemptLogin($request)) {
                $user = Auth::user();
                
                $userInfo = collect();
                $userInfo['token'] = $user->createToken('AccessToken')->accessToken;
                
                return $this->success($userInfo);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->failed('账户或密码错误');

            return $this->succcess();
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    /**
     * 注册处理函数
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone' => ['required', 'unique:users'],
            'verify_code' => ['required', new VerifyCode($request->phone)],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        DB::beginTransaction();

        try {
            event(new Registered($user = $this->create($request->all())));

            $this->guard()->login($user);

            DB::commit();

            return $this->success('注册成功!');
        } catch (\Throwable $th) {
            DB::rollback();

            return $this->failed($th->getMessage());
        }
    }

    /**
     * 创建用户记录
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'agent_id' => isset($data['agent_id']) && !empty($data['agent_id']) ? $data['agent_id'] : 0,
            'community_header_id' => isset($data['community_header_id']) && !empty($data['community_header_id']) ? $data['community_header_id'] : 0,
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
        ]);
    }

    /**
     * 发送验证码函数
     *
     * @param Request $request
     * @return Response
     */
    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^1[3456789]\d{9}$/'],
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }

        try {
            $this->sendSms($request->phone);

            return $this->success([
                "seconds" => 60,
                "msg"     => "验证码已发送"
            ]);
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    /**
     * 重置用户密码函数
     *
     * @param Request $request
     * @return Response
     */
    public function reset(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'phoneNumber' => 'required',
                'code' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->failed('字段为空');
            }

            if (!$this->verifyCode($request->phoneNumber, $request->code)) {
                return $this->failed('验证码错误');
            }

            $user = User::where('phone', $request->phoneNumber)->first();

            if (empty($user) or !isset($user->id)) {
                return $this->failed('手机号码不存在');
            }

            $user->password = Hash::make($request->password);

            $user->save();

            DB::commit();

            $userInfo = collect();
            $userInfo['accessToken'] = $user->createToken('AccessToken')->accessToken;
            $userInfo['username'] = $user->name;
            $userInfo['face'] = $user->avatar;
            $userInfo['signature'] = $user->signature ? $user->signature : '个性签名';

            return $this->success($userInfo);
        } catch (\Exception $e) {
            DB::rollback();
            
            return $this->failed($e->getMessage());
        }
    }

    /**
     * 设置用户信息函数
     *
     * @param Request $request
     * @return Response
     */
    public function setUserInfo(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'phoneNumber' => 'required',
                'code' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->failed('字段为空');
            }

            if (!$this->verifyCode($request->phoneNumber, $request->code)) {
                return $this->failed('验证码错误');
            }

            $user = Auth::user();

            $user->phone = $request->phoneNumber;
            $user->password = Hash::make($request->password);

            $user->save();

            DB::commit();

            return $this->success('设置成功');
        } catch (\Exception $e) {
            DB::rollback();
            
            return $this->failed($e->getMessage());
        }
    }

    /**
     * 手机号码登陆方法
     *
     * @param Request $request
     * @return Response
     */
    public function loginByMobile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'code'  => ['required']
            ]);

            if ($validator->fails()) {
                return $this->failed($validator->errors());
            }
            
            $phone = $request->phone;
            $code  = $request->code;

            if (!$this->verifyCode($phone, $code)) {
                return $this->failed("验证码错误");
            }

            $user = User::where('phone', $phone)->first();

            if (empty($user)) {
                return $this->failed("未找到用户", 203);
            }

            $userOauth = $user->oauth;

            if (empty($userOauth) or $userOauth->isEmpty()) {
                return $this->failed("用户未绑定微信", 203); 
            }
            
            $userInfoResponse['name'] = $user->name;
            $userInfoResponse['avatar'] = $user->avatar;
            $userInfoResponse['gender'] = $user->gender;
            $userInfoResponse['balance'] = $user->balance;
            $userInfoResponse['integral'] = $user->integral;
            $userInfoResponse['signature'] = $user->signature;
            $userInfoResponse['phone'] = $user->phone;
            $userInfoResponse['email'] = $user->email;
            $userInfoResponse['is_community_header'] = $user->hasCommunityHeaders();
            $userInfoResponse['access_token'] = $user->createToken('AccessToken')->accessToken;

            return $this->success($userInfoResponse);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * 微信小程序登录函数
     *
     * @param Request $request
     * @return Response
     */
    public function loginByWechat(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required',
                'name' => 'required',
                'avatar' => 'required',
                'gender' => ['required'],
                'phone' => ['sometimes']
            ]);

            if ($validator->fails()) {
                return $this->failed($validator->errors());
            }

            $app = \EasyWeChat::miniProgram();
            $code = $request->code;

            $result = $app->auth->session($code);

            if (isset($result['openid'])) {
                $userOauth = UserOauth::where('type', 'wechat')->where('openid', $result['openid'])->with('user')->first();

                $userInfoResponse = [];

                if ($userOauth) {
                    if ($userOauth->user) {
                        $userOauth->session_key = $result['session_key'];
                        $userOauth->save();

                        $user = $userOauth->user;
                        !isset($request->phone) ?: $user->phone = $request->phone;

                        $user->name = $request->name;
                        $user->avatar = $request->avatar;
                        $user->gender = $request->gender;
                        
                        $userInfoResponse['name'] = $user->name;
                        $userInfoResponse['avatar'] = $user->avatar;
                        $userInfoResponse['gender'] = $user->gender;
                        $userInfoResponse['balance'] = $user->balance;
                        $userInfoResponse['integral'] = $user->integral;
                        $userInfoResponse['signature'] = $user->signature;
                        $userInfoResponse['phone'] = $user->phone;
                        $userInfoResponse['email'] = $user->email;
                        $userInfoResponse['is_community_header'] = $user->hasCommunityHeaders();
                        $userInfoResponse['access_token'] = $user->createToken('AccessToken')->accessToken;
                        
                        $user->save();

                        $userInfoEmpty = empty($user->phone) ? true : false;
                    } else {
                        $userInfoArray = [
                            'name' => $request->name,
                            'avatar' => $request->avatar,
                            'gender' => $request->gender,
                            'email' => NULL,
                            'agent_id' => $request->agent_id ? $request->agent_id : 0,
                            'password' => ''
                        ];

                        !isset($request->phone) ?: $userInfoArray['phone'] = $request->phone;
                        
                        $user = User::create($userInfoArray);

                        $user->oauth()->save($userOauth);

                        $userInfoResponse['name'] = $user->name;
                        $userInfoResponse['avatar'] = $user->avatar;
                        $userInfoResponse['gender'] = $user->gender;
                        $userInfoResponse['balance'] = $user->balance;
                        $userInfoResponse['integral'] = $user->integral;
                        $userInfoResponse['signature'] = $user->signature;
                        $userInfoResponse['phone'] = $user->phone;
                        $userInfoResponse['email'] = $user->email;
                        $userInfoResponse['is_community_header'] = $user->hasCommunityHeaders();
                        $userInfoResponse['access_token'] = $user->createToken('AccessToken')->accessToken;
                        $userInfoEmpty = empty($user->phone) ? true : false;
                    }
                } else {
                    if (isset($request->phone)) {
                        $user = User::where('phone', $request->phone)->first();
                        
                        if (!empty($user)) {
                            $user->name = $request->name;
                            $user->avatar = $request->avatar;
                            $user->gender = $request->gender;

                            $userOauth = new UserOauth([
                                'type' => 'wechat',
                                'openid' => $result['openid'],
                                'session_key' => $result['session_key'],
                            ]);
        
                            $user->oauth()->save($userOauth);
                            
                            $userInfoResponse['name'] = $user->name;
                            $userInfoResponse['avatar'] = $user->avatar;
                            $userInfoResponse['gender'] = $user->gender;
                            $userInfoResponse['balance'] = $user->balance;
                            $userInfoResponse['integral'] = $user->integral;
                            $userInfoResponse['signature'] = $user->signature;
                            $userInfoResponse['phone'] = $user->phone;
                            $userInfoResponse['email'] = $user->email;
                            $userInfoResponse['is_community_header'] = $user->hasCommunityHeaders();
                            $userInfoResponse['access_token'] = $user->createToken('AccessToken')->accessToken;
                            
                            $user->save();
                        } else {
                            $userInfoArray = [
                                'name' => $request->name,
                                'avatar' => $request->avatar,
                                'gender' => $request->gender,
                                'email' => NULL,
                                'agent_id' => $request->agent_id ? $request->agent_id : 0,
                                'password' => ''
                            ];
        
                            $userInfoArray['phone'] = $request->phone;
                            
                            $user = User::create($userInfoArray);
        
                            $userOauth = new UserOauth([
                                'type' => 'wechat',
                                'openid' => $result['openid'],
                                'session_key' => $result['session_key'],
                            ]);
        
                            $user->oauth()->save($userOauth);
        
                            $userInfoResponse['name'] = $user->name;
                            $userInfoResponse['avatar'] = $user->avatar;
                            $userInfoResponse['gender'] = $user->gender;
                            $userInfoResponse['balance'] = $user->balance;
                            $userInfoResponse['integral'] = $user->integral;
                            $userInfoResponse['signature'] = $user->signature;
                            $userInfoResponse['phone'] = $user->phone;
                            $userInfoResponse['email'] = $user->email;
                            $userInfoResponse['is_community_header'] = $user->hasCommunityHeaders();
                            $userInfoResponse['access_token'] = $user->createToken('AccessToken')->accessToken;

                        }

                        $userInfoEmpty = false;
                    } else {
                        $userInfoArray = [
                            'name' => $request->name,
                            'avatar' => $request->avatar,
                            'gender' => $request->gender,
                            'email' => NULL,
                            'agent_id' => $request->agent_id ? $request->agent_id : 0,
                            'password' => ''
                        ];
    
                        !isset($request->phone) ?: $userInfoArray['phone'] = $request->phone;
                        
                        $user = User::create($userInfoArray);
    
                        $userOauth = new UserOauth([
                            'type' => 'wechat',
                            'openid' => $result['openid'],
                            'session_key' => $result['session_key'],
                        ]);
    
                        $user->oauth()->save($userOauth);
    
                        $userInfoResponse['name'] = $user->name;
                        $userInfoResponse['avatar'] = $user->avatar;
                        $userInfoResponse['gender'] = $user->gender;
                        $userInfoResponse['balance'] = $user->balance;
                        $userInfoResponse['integral'] = $user->integral;
                        $userInfoResponse['signature'] = $user->signature;
                        $userInfoResponse['phone'] = $user->phone;
                        $userInfoResponse['email'] = $user->email;
                        $userInfoResponse['is_community_header'] = $user->hasCommunityHeaders();
                        $userInfoResponse['access_token'] = $user->createToken('AccessToken')->accessToken;
                        $userInfoEmpty = empty($user->phone) ? true : false;
                    }
                }
                
                DB::commit();

                if (isset($userInfoEmpty) && $userInfoEmpty) {
                    return $this->setStatusCode(203)->success($userInfoResponse);
                } else {
                    return $this->success($userInfoResponse);
                }
            } else {
                return $this->failed($result);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->failed($e->getMessage());
        }
    }
}
