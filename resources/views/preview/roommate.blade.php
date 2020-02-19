<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
    .male{
        background-color: #2877b5;
        color: white;
        margin: 3px;
    }
    .female{
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
    <p>▼▼在平台的聊天框回复对应嘉宾编号▼▼</p><br>
    <p> 如：{{$keyword}}999，即可获得联系方式</p><br>
    @foreach($infos as $info)

    <div>
        <div><span><img width="100%" src='{{$info["extra"]->person_image}}'></span></div>
        <div><span class="{{$info['extra']->sex}}">&nbsp&nbsp嘉宾编号：{{$keyword}}{{$info['id']}}&nbsp</span></div>
        <div><div style="display:block;"><hr class="{{$info['extra']->sex}}" size='5'/></div></div>
        <div><span class="{{$info['extra']->sex}}">&nbsp&nbsp昵称：</span><span>{{$info['extra']->ta_name}}</span></div>
        <div><span class="{{$info['extra']->sex}}">&nbsp&nbsp产地：</span><span>{{$info['extra']->origin}}</span></div>
        <div><span class="{{$info['extra']->sex}}">&nbsp&nbsp学校：</span><span>{{$info['extra']->university}}</span></div>
        <div><span class="{{$info['extra']->sex}}">&nbsp&nbsp身高：</span><span>{{$info['extra']->height}}</span></div>
        <div><span class="{{$info['extra']->sex}}">&nbsp&nbsp个人描述：</span><span>{{$info['extra']->specialty}}</span></div>
        <div><span class="{{$info['extra']->sex}}">&nbsp&nbsp匹配对象：</span><span>{{$info['extra']->expectation}}</span></div>
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