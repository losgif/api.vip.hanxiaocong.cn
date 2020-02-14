<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
    .male{
        font-weight: 800;
        margin: 3px;
        
    }
    .female{
        font-weight: 800;
        margin: 3px;
    }
    .info span{
        display: inline-block;
        margin: 0 5px;
        font-size: 14px;
    }
    span {
        font-size: 20px;
    }
    p{
        text-align: center;
        font-size: 14px;
        color: rgb(255, 104, 39);
    }
    .question-title {
        color: rgb(120, 172, 254);
        word-wrap: break-word !important;
        font-size: 15px;
        padding: 10px 0;
    }
    .question-content {
        font-size: 14px;
        white-space: pre-line;
        padding: 10px 0;
    }
    </style>
    <script src="https://cdn.bootcss.com/clipboard.js/2.0.0/clipboard.min.js"></script>
</head>
<body>
    <p>▼▼在平台的聊天框回复对应选手编号▼▼</p><br>
    <p> 如：LOVE999，即可获得联系方式</p><br>
    @foreach($infos as $info)

    <div>
        <div class="info">
            <div><img width="100%" src='{{$info["person_image"]}}'></div>
            <div><span style="font-size: 16px; color: red;" class="{{$info['sex']}}">&nbsp&nbsp编号：love{{$info['id']}}&nbsp</span></div>
            <div><span class="{{$info['sex']}}">&nbsp&nbsp昵称：</span><span>{{$info['name']}}</span></div>
            <div><span class="{{$info['sex']}}">&nbsp&nbsp产地：</span><span>{{$info['origin']}}</span></div>
            <div><span class="{{$info['sex']}}">&nbsp&nbsp学校：</span><span>{{$info['university']}}</span></div>
            <div><span class="{{$info['sex']}}">&nbsp&nbsp院系：</span><span>{{$info['department']}}</span></div>
            <div><span class="{{$info['sex']}}">&nbsp&nbsp身高：</span><span>{{$info['height']}}CM</span></div>
            <div><span class="{{$info['sex']}}">&nbsp&nbsp星座：</span><span>{{$info['constellation']}}</span></div>
            <div><span class="{{$info['sex']}}">&nbsp&nbsp微博：</span><span>{{$info['weibo']}}</span></div>
            <div><span style="white-space: pre-line;" class="{{$info['sex']}}">&nbsp&nbsp特长：</span><span>{{$info['specialty']}}</span></div>
        </div>
        <br>
        @if (!empty(json_decode($info['extra'])))
            @foreach (json_decode($info['extra']) as $e)
            <div>
                <p><span class="question-title">{{ $e->title }}</span></p>
                <div><span class="question-content">{{ $e->content }}</span></div>
                <div><img width="100%" style="margin-bottom: 20px;" src="{{ $e->image }}" alt="question_{{ $loop->index + 1 }}"></div>
            </div>
            @endforeach
        @endif
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