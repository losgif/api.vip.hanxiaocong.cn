<!DOCTYPE html>
<html lang = "zh-CN">
    <head>
            <meta charset = "UTF-8">
            <meta name="viewport" content = "width=device-width,initial-scale=1,user-scalable=0">
            <link rel = "stylesheet" href = "https://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css">
            <style>
                body{
                    background-size: cover;
                    background-attachment: fixed;
                    width: 100%;
                    height: 100%;
                }
                .rule{
                    display: block;
                    margin: 20px;
                    font-size: 12px;
                }
                .rule_o{
                    display: block;
                }
                .rule_t{
                    display: inline-block;
                    margin-top: 10px;
                    background-color: black;
                    color: white;
                }
                .weui-cells__tips {
                color: red;
                font-size: 4px;        
                }
                .weui-cells__title {
                    color: #333;
                    font-size: 18px;
                }
                .weui-cells__tips{
                    font-size: 14px;
                }
                .app {
                    background: #fff;
                    margin: 15px !important;
                }
            </style>
    </head>
    <body>
    <form action="/upload" method="POST">
        {{ csrf_field() }}
        <div class="app">
            <div style="text-align:center">
            <img src="/image/22.jpg">
            </div>
            <div style="margin-top:-20px;">
                <div class="rule">    
                    <span style="color: red; display:block;padding-top: 20px;font-size:16px;">
                        济南大学助手卖舍友游戏规则
                    </span>
                </div>
                <div class="rule">
                        <span>1.可以适当的黑自己的舍友、闺蜜、好基友~济南大学助手会进行审核然后发布。最重要的是，欢迎冒充舍友自黑!</span>
                        <div class="rule_o">
                        <span class="rule_t">我们的原则是：有对象的不能上。 </span>
                        <span class="rule_t">同时拒绝无脑低端黑，希望大家遵守。</span>
                        </div>
                </div>
                <div class="rule">
                        <span>2.我们不会将任何一个人的联系方式直接发布到网络。想知道他的联系方式吗？在平台里直接发送编号（如love999），即可收到TA的联系方式 </span>                   
                </div>
                <div class="rule">
                        <span>3.已报名但没有上当日图文的同学，不要着急，一周内就会有你。</span>                 
                </div>
                <div class="rule">
                        <span>4.关于上传照片要求 </span>                  
                        <div class="rule_o">
                        <span class="rule_t">上传照片需清晰、无马赛克、有正脸</span>  
                        <span class="rule_t">资料填写要有个性，不得低于18字符</span> 
                        </div>    
                </div>
                <div class="rule">
                        <span>5.快来“卖”自己有趣的舍友！cheeky</span>      
                </div>
                <div class="rule">
                        <span>6.如果被卖人不希望被打扰或已成功脱单，请联系我们，我们会及时删除你的联系方式。</span>                       
                </div>
                <div class="rule">
                        <span>7.济南大学助手卖舍友，让你从此不再一个人。同学们赶紧拿起手中的手机订购吧!</span>       
                </div>
                <div class="rule">
                        <span>8.济南大学助手开发，bug及建议反馈请联系小葱：ujnhand@qq.com</span>
                </div>
            </div>
            <div class="weui-cells__title">被卖人（昵称）*</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="name" placeholder="输入被卖人昵称"/>
                    </div>
                </div>
            </div>
            <div class="weui-cells__tips">tips：必填！！！乱填或空着可能会减少上舍友的几率哦~</div>

            <div class="weui-cells__title">性别 *</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div>
                        <input type="radio" name="sex" value="man" checked="true"/><label>男神</label>
                        <input type="radio" name="sex" value="woman"/><label>女神</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-cells__title">学院与年级 *</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="grade" placeholder="输入学院或年级"/>
                    </div>
                </div>
            </div>
            <div class="weui-cells__tips">tips：必填！！！乱填或空着可能会减少上舍友的几率哦~</div>

            <div class="weui-cells__title">TA的联系方式（标注微信或者QQ*)</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="ta_tel" placeholder="输入TA的联系方式" required/>
                    </div>
                </div>
            </div>
            <div class="weui-cells__tips">tips：必填！标注是QQ还是微信</div>

            <div class="weui-cells__title">你的联系方式（标注微信或者QQ)*</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="my_tel" placeholder="输入你的联系方式" required />
                    </div>
                </div>
            </div>
            <div class="weui-cells__tips">tips：必填！以便随时沟通联系</div>

            <div class="weui-cells__title">舍友身高 *</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="height" placeholder="输入舍友身高"/>
                    </div>
                </div>
            </div>

            <div class="weui-cells__title">舍友产地 (出生地）*</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="brith_place" placeholder="输入舍友产地"/>
                    </div>
                </div>
            </div>

            <div class="weui-cells__title">描述舍友（爆料）*</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <textarea class="weui-textarea" placeholder="请输入爆料内容" rows="3" name="detail"></textarea>
                    </div>
                </div>
            </div>
            <div class="weui-cells__tips">tips：写上他的品质以及兴趣爱好。            
            我想你认真对待的话，别人也会认真了解你～</div>

            <div class="weui-cells__title">Ta（舍友）对另一半的期望（喜欢哪种类型）*</div>
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <textarea class="weui-textarea" placeholder="请输入TA喜欢的类型" rows="3" name="expect"></textarea>
                    </div>
                </div>
            </div>
            <div class="weui-cells__tips">tips：结合现实，遵循本心~</div>

            <div class="weui-cells__title">选择图片</div>
            <div class="weui-cell" id="upload-container">
                <a class="btn btn-default btn-lg" id="pickfiles" href="#" >
                    <input class="weui-input" type="file" name="upload_url">
                </a>
                <input type="text" style="display: none" name="upload_url" id="upload_url">
            </div>
            <label style="font-size:16px;" id="fileName"></label>
            <div class="weui-cells__tips">tips：请附上你的清晰照，照片上传成功后再提交哦！</div>

            <div class="weui-btn-area">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips" onclick="submitForm()">提交</a>
            </div>         
        </div>  
    </form>  
    </body>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/plupload/2.1.9/moxie.js"></script>
<script src="https://cdn.staticfile.org/plupload/2.1.9/plupload.dev.js"></script>
<script src="https://cdn.staticfile.org/qiniu-js-sdk/1.0.14-beta/qiniu.min.js"></script>
<script>
    //判断是否上传成功
    if ( {{ $result }} ) {
        alert("信息提交成功")
    }
    //表单提交
    function submitForm () {
        var name        = document.getElementsByName('name')[0].value
        var sex         = document.getElementsByName('sex').value
        var ta_tel      = document.getElementsByName('ta_tel')[0].value
        var my_tel      = document.getElementsByName('my_tel')[0].value
        var grade       = document.getElementsByName('grade')[0].value
        var height      = document.getElementsByName('height')[0].value
        var birth_place = document.getElementsByName('brith_place')[0].value
        var detail      = document.getElementsByName('detail')[0].value
        var expect      = document.getElementsByName('expect')[0].value
        if ( '' == name ) {
            alert("昵称不可为空!")
            return false;
        }else if ( '' == sex ) {
            alert("请选择性别！")
            return false;
        }else if ( '' == ta_tel ) {
            alert("TA的联系方式不可为空!")
            return false;
        }else if ( '' == my_tel ) {
            alert("你的联系方式不可为空!")
            return false;
        }else if ( '' == grade ) {
            alert("年级或学院不可为空!")
            return false;
        }else if ( '' == height ) {
            alert("身高不可为空!")
            return false;
        } else if ( '' == birth_place ) {
            alert("出生地不可为空!")
            return false;
        } else if ( '' == detail ) {
            alert("爆料不可为空!")
            return false;
        } else if ( '' == expect ) {
            alert("期望不可为空!")
            return false;
        } else {
            $('form').submit();
        }
    }
    //文件上传，七牛云
    function uploaderReady() {
        var uploader = Qiniu.uploader({
            disable_statistics_report: false,   // 禁止自动发送上传统计信息到七牛，默认允许发送
            runtimes: 'html5,flash,html4',      // 上传模式,依次退化
            browse_button: 'pickfiles',         // 上传选择的点选按钮，**必需**
            // 在初始化时，uptoken, uptoken_url, uptoken_func 三个参数中必须有一个被设置
            // 切如果提供了多个，其优先级为 uptoken > uptoken_url > uptoken_func
            // 其中 uptoken 是直接提供上传凭证，uptoken_url 是提供了获取上传凭证的地址，如果需要定制获取 uptoken 的过程则可以设置 uptoken_func
            uptoken : '{{ $token }}', // uptoken 是上传凭证，由其他程序生成
            // uptoken_url: '/uptoken',         // Ajax 请求 uptoken 的 Url，**强烈建议设置**（服务端提供）
            // uptoken_func: function(file){    // 在需要获取 uptoken 时，该方法会被调用
            //    // do something
            //    return uptoken;
            // },
            get_new_uptoken: false,             // 设置上传文件的时候是否每次都重新获取新的 uptoken
            // downtoken_url: '/downtoken',
            // Ajax请求downToken的Url，私有空间时使用,JS-SDK 将向该地址POST文件的key和domain,服务端返回的JSON必须包含`url`字段，`url`值为该文件的下载地址
            unique_names: true,              // 默认 false，key 为文件名。若开启该选项，JS-SDK 会为每个文件自动生成key（文件名）
            // save_key: true,                  // 默认 false。若在服务端生成 uptoken 的上传策略中指定了 `save_key`，则开启，SDK在前端将不对key进行任何处理
            domain: '{{ $domain }}',     // bucket 域名，下载资源时用到，如：'http://xxx.bkt.clouddn.com/' **必需**
            container: 'upload-container',             // 上传区域 DOM ID，默认是 browser_button 的父元素，
            max_file_size: '100mb',             // 最大文件体积限制
            flash_swf_url: '{{ asset("Moxie.swf") }}',  //引入 flash,相对路径
            max_retries: 3,                     // 上传失败最大重试次数
            dragdrop: true,                     // 开启可拖曳上传
            drop_element: 'upload-container',          // 拖曳上传区域元素的 ID，拖曳文件或文件夹后可触发上传
            chunk_size: '4mb',                  // 分块上传时，每块的体积
            auto_start: true,                  // 选择文件后自动上传，若关闭需要自己绑定事件触发上传,
            //x_vars : {
            //    自定义变量，参考http://developer.qiniu.com/docs/v6/api/overview/up/response/vars.html
            //    'time' : function(up,file) {
            //        var time = (new Date()).getTime();
                      // do something with 'time'
            //        return time;
            //    },
            //    'size' : function(up,file) {
            //        var size = file.size;
                      // do something with 'size'
            //        return size;
            //    }
            //},
            init: {
                'FilesAdded': function(up, files) {
                    plupload.each(files, function(file) {
                        // 文件添加进队列后,处理相关的事情
                    });
                },
                'BeforeUpload': function(up, file) {
                       // 每个文件上传前,处理相关的事情
                       console.log('开始上传：', file)
                       document.getElementById('fileName').innerHTML = "正在上传..."
                },
                'UploadProgress': function(up, file) {
                       // 每个文件上传时,处理相关的事情
                       console.log('上传时：', file)
                       document.getElementById('fileName').innerHTML = "已上传: " + file.percent + "%"
                },
                'FileUploaded': function(up, file, info) {
                       // 每个文件上传成功后,处理相关的事情
                       // 其中 info.response 是文件上传成功后，服务端返回的json，形式如
                       // {
                       //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                       //    "key": "gogopher.jpg"
                       //  }
                       // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
        
                        var domain = up.getOption('domain');
                        var res = $.parseJSON(info);
                        var sourceLink = domain + res.key; //获取上传成功后的文件的Url
                        document.getElementById('upload_url').value = sourceLink
                        document.getElementById('fileName').innerHTML = file.name + " 文件已上传"
                        alert('文件上传成功')
                },
                'Error': function(up, err, errTip) {
                       //上传出错时,处理相关的事情
                       console.log(errTip)
                       console.log(err)
                       alert(errTip)
                },
                'UploadComplete': function() {
                       //队列文件处理完毕后,处理相关的事情
                },
                'Key': function(up, file) {
                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                    // 该配置必须要在 unique_names: false , save_key: false 时才生效
        
                    var key = "";
                    // do something with key here
                    return key
                }
            }
        });
    }
    //让页面初始化的时候就请求
    $(document).ready(function(){
        uploaderReady();
    });
</script>
</html>