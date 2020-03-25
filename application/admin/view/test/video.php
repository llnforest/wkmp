<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<iframe class="video_iframe" style="z-index:1;" src="https://v.qq.com/iframe/player.html?vid=k00290g0i00&amp;width=500&amp;height=375&amp;auto=0" allowfullscreen="" frameborder="0" height="375" width="500"></iframe>
<div id="start_btn" style="height:40px;width:100px;text-align: center;background:red;color:#fff;line-height: 40px;">开始</div>
<div id="bf" onclick="bf();"  style="height:40px;width:100px;text-align: center;background:red;color:#fff;line-height: 40px;">播放/暂停</div>
<div id="bf" onclick="rbf();"  style="height:40px;width:100px;text-align: center;background:red;color:#fff;line-height: 40px;">重新播放</div>
<video id="video" src="http://videohy.tc.qq.com/vkp.tc.qq.com/AP9JJv9kc6P3atGrjCSNP8ZINSLQHQW0ivdDjBMubS2o/uwMROfz2r5zEIaQXGdGnC2dfDmafRkP9ujxgqKjuATzMrE-2/k00290g0i00.mp4?vkey=B16E9D9FC94A90BF830F90A4B804B9F6BFCB58148F9E7F201C60ABCC5D32F368152575B5C3FF9C8B2874ED196B14BC7008E39C6BF677FCA89094E36A153F08B6CD12A8A844AC93684AFA5EC13A2CB42A5C2E37E00A3ADF8889446C48E123A184C549784B4DE28A2D2D7035CFA08B88F553EFD7A494A2D54720BF6EBF8F495F52&br=70&platform=2&fmt=auto&level=0&sdtfrom=v3010&guid=46213cc5688f6dacaedb2a2091516171&ocid=253929481" controls="controls">video>

<script>
    function rbf(){
        var audio = document.getElementById('music1');
        audio.currentTime = 0;
    }
    function bf(){
        var audio = document.getElementById('video');
        if(audio!==null){
            //检测播放是否已暂停.audio.paused 在播放器播放时返回false.
            alert(audio.paused);
            if(audio.paused)                     {
                audio.play();//audio.play();// 这个就是播放
            }else{
                audio.pause();// 这个就是暂停
            }
        }
    }

</script>
</body>

<script src="__ADMINSTATIC__/js/jquery/jquery-1.8.0.min.js"></script>
<script>
    $("#start_btn").click(function(){
        console.log(1);
        $(".video_iframe").click();
    })
</script>
</html>