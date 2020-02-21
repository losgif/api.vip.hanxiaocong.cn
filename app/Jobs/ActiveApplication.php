<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Weixiao;
use App\School;
use App\User;
use App\SchoolApplication;
use App\ApplicationPlatform;
use DB;
use Illuminate\Support\Str;
use Hash;

class ActiveApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Weixiao;

    public $parameters;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        
        try {
            $user = new User();
            $user->name = "微校用户" . Str::random(6);
            $user->password = Hash::make(Str::random(6));
            
            $user->save();

            $user->assignRole('normal-user');

            $applicationPlatform = ApplicationPlatform::where('key', $this->parameters['api_key'])->where(['type' => 'weixiao'])->first();
            $application = $applicationPlatform->application;
            
            $school = new School();
            $hasSchool = School::where('media_id', $this->parameters['media_id'])->first();
    
            if ($hasSchool) {
                $school = $hasSchool;
            }
            
            $school->media_id = $this->parameters['media_id'];
            $school->user_id = $user->id;

            $result = $this->getWeixiaoInfo($this->parameters['media_id'], $applicationPlatform->key, $applicationPlatform->secret);
            $result = json_decode($result);
            
            if (isset($result->media_id)) {
                $school->name = $result->name;
                $school->media_number = $result->media_number;
                $school->avatar_image = $result->avatar_image;
                $school->media_type = $result->media_type;
                $school->media_url = $result->media_url;
                $school->school_name = $result->school_name;
                $school->school_code = $result->school_code;
                $school->verify_type = $result->verify_type;
            }
            
            $school->save();

            $schoolApplication = new SchoolApplication();
            $schoolApplication->school_id = $school->id;
            $schoolApplication->application_id = $application->id;
            $schoolApplication->name = $application->name;
            $schoolApplication->type = $application->type;
            $schoolApplication->description = $application->description;
            $schoolApplication->logo = $application->logo;
            
            $schoolApplication->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
            throw $th;
        }
    }
}
