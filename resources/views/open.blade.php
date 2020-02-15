<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
    .man{
        background-color: #2877b5;
        color: white;
        margin: 3px;
    }
    .woman{
        background-color: red;
        color: white;
        margin: 3px;
    }
    span{
        display: inline-block;
        margin: 5px;
        font-size: 14px;
    }
    p{
        text-align: center;
        font-size: 14px;
        height: 10px;
        color: rgb(255, 104, 39);
    }
    </style>
    <script src="https://cdn.bootcss.com/clipboard.js/2.0.0/clipboard.min.js"></script>
</head>
<body>
    <p>▼▼在平台的聊天框回复对应选手编号▼▼</p><br>
    <p> 如：LOVE999，即可获得联系方式</p><br>
    @foreach($infos as $info)

    <div>
        <div><span><img width="100%" src='{{$info["upload_url"]}}'></span></div>
        <div><span class="{{$info['sex']}}">&nbsp&nbsp编号：BG{{$info['id']}}&nbsp</span></div>
        <div><div style="display:block;"><hr class="{{$info['sex']}}" size='5'/></div></div>
        <div><span class="{{$info['sex']}}">&nbsp&nbsp昵称：</span><span>{{$info['name']}}</span></div>
        <div><span class="{{$info['sex']}}">&nbsp&nbsp产地：</span><span>{{$info['brith_place']}}</span></div>
        <div><span class="{{$info['sex']}}">&nbsp&nbsp学校：</span><span>{{$info['grade']}}</span></div>
        <div><span class="{{$info['sex']}}">&nbsp&nbsp身高：</span><span>{{$info['height']}}</span></div>
        <div><span class="{{$info['sex']}}">&nbsp&nbsp个人描述：</span><span>{{$info['detail']}}</span></div>
        <div><span class="{{$info['sex']}}">&nbsp&nbsp匹配对象：</span><span>{{$info['expect']}}</span></div>
        <br>
    </div>

    @endforeach
</body>
<script>
        var clipboard = new ClipboardJS(".copy", {
            target: document.getElementsByTagName('body')[0]
          });
              
          clipboard.on("success", function(e) {
            console.info("Action:", e.action);
            console.info("Text:", e.text);
            console.info("Trigger:", e.trigger);
      
            e.clearSelection();
          });
      
          clipboard.on("error", function(e) {
            console.error("Action:", e.action);
            console.error("Trigger:", e.trigger);
          });
</script>
</html>