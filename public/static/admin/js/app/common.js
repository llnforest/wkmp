/** 判断传入对象是否为空 **/
function isEmpty(obj){
    if(typeof obj == "undefined" || obj == null || obj == "" || obj == "null" || obj == "NULL"){
        return true;
    }else{
        return false;
    }
}

//渲染日历方法
function renderDatePicker(){
    if($(".date-time").length > 0){
        //时间日期渲染
        layui.use('laydate', function(){
            var laydate = layui.laydate;
            $(".date-time").each(function(){
                var format = $(this).attr("dom-format") || 'yyyy-MM-dd';
                var type = $(this).attr("dom-type") || 'date';
                laydate.render({
                    elem:this,
                    format:format,
                    type:type
                })
            })
        });
    }
}

layui.use('upload', function(){
    var upload = layui.upload;

    //执行实例，上传图片
    if($(".upload").length > 0){
        upload.render({
            elem: '.upload' //绑定元素
            ,field: 'file'
            ,size:0
            ,before:function(){
                loading = layer.load(2, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
            }
            ,done: function(res,index,upload){
                //上传完毕回调
                $(this)[0].item.find(".image").val(res.url);
                var path = $(this)[0].item.find(".mini-image").attr("data-path");
                $(this)[0].item.find(".mini-image").removeClass("hidden").attr("src",path+res.url);
                layer.close(loading);
            }
            ,error: function(index,upload){
                //请求异常回调
                console.log('wrong');
            }
        });
    }

    //执行实例，上传图片
    if($(".import").length > 0) {
        upload.render({
            elem: '.import' //绑定元素
            , field: 'excelfile'
            , exts:'xlsx'
            , size: 0
            ,before:function(){
                layer.load(2, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
            }
            , done: function (res, index, upload) {
                //上传完毕回调
                if(res.code == 1){
                    $('#alert').html(alertSuccess(res.msg));
                    set_time = setTimeout(function() {
                        window.location.reload();
                    },sec);
                }else{
                    $('#alert').html(alertDanger(res.msg));
                }
                set_time = setTimeout(function() {
                    $('.close').click();
                    window.location.reload();
                },sec);
                layer.closeAll('loading');
            }
            , error: function (index, upload) {
                //请求异常回调
                layer.closeAll('loading');
            }
        });
    }
});

//鼠标悬停显示图片
$(function(){
    var x = 10;
    var y = 20;
    $(".mini-image").mouseover(function(e){
        var href= $(this).attr('src');
        var tooltip = "<div id='tooltip'><img src='"+ href +"' alt='预览图' height='200'/>"+"<\/div>"; //创建 div 元素
        $("body").append(tooltip);  //把它追加到文档中
        $("#tooltip")
            .css({
                "top": (e.pageY+y) + "px",
                "left":  (e.pageX+x)  + "px"
            }).show("fast");    //设置x坐标和y坐标，并且显示
    }).mouseout(function(){
        $("#tooltip").remove();  //移除
    }).mousemove(function(e){
        $("#tooltip")
            .css({
                "top": (e.pageY+y) + "px",
                "left":  (e.pageX+x)  + "px"
            });
    });
})