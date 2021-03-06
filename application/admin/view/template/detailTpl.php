
<html>
<head>
    <title>{$title?:''}</title>
    {include file="template/headTpl"}
    {block name="headBody"}<!-- 头部引用区域 -->{/block}
</head>

<body>
<form class="layui-form layui-form-plat" name="detailForm" method="POST" action="">
    <input type="hidden" name="id" value="{$info.id??''}"/>
    <input type="hidden" id="jump" value="{$info.jump??'true'}" />
    {block name="formBody"}<!-- 头部引用区域 -->{/block}
    <div class="layui-form-item">
        <div class="layui-input-block-bottom">
            <button class="layui-btn {$Request.param.readonly!=null?'layui-hide':''}" lay-submit lay-filter="submitForm"><i class="layui-icon">&#xe605;</i>提交</button>
            <button class="layui-btn {$Request.param.readonly!=null?'layui-hide':''}" type="reset" > <i class="layui-icon">&#xe621;</i>重置</button>
            <button class="layui-btn layui-btn-danger" type="button" id="closeBut"><i class="layui-icon">&#x1006;</i>关闭</button>
        </div>
    </div>
</form>

<script>
    layui.use(['form','layer'], function(){
        var form = layui.form;
        var layer = layui.layer;
        var $ = layui.jquery;

        {if(isset($readonly) && $readonly)}
            $("input,textarea,select,radio,checkbox").attr('readonly',true);
        {/if}

        {if !isset($readonly)}
        //监听提交
        form.on('submit(submitForm)', function(data){
            //监听多图处理
            if($(".img-wrap").length > 0){
                var sublist = [];
                $(".img-wrap .img-block").each(function(index,item){
                    var url = $(item).find(".image").val();
                    if(url == '') return;
                    var sort = $(item).find(".img-sort").val().trim();
                    sublist.push({'img':url,sort:sort});
                })
                console.log(JSON.stringify(sublist));
                data.field.img_data = JSON.stringify(sublist);
            }
            if(data.field.status == undefined && $('[name="status"]').val() == 0) data.field.status = 0;
            submitForm(data);
            return false;
        });
        {/if}

        //关闭自身弹出层
        $("#closeBut").click(function(){
            var index= window.parent.layer.getFrameIndex(window.name);
            window.parent.layer.close(index);
        });

        //监听状态操作
        form.on('switch(status)', function(obj){
            $(this).val(obj.elem.checked?1:0);
        });

        //增加必填项
        $("input[lay-verify='required']").parents(".layui-form-item").find(".layui-form-label").addClass("require-mark");
        $("select[lay-verify='required']").parents(".layui-form-item").find(".layui-form-label").addClass("require-mark");
        $("textarea[lay-verify='required']").parents(".layui-form-item").find(".layui-form-label").addClass("require-mark");
    });

    //提交表单
    function submitForm(data){
        var index= window.parent.layer.getFrameIndex(window.name);
        data.extend = {name:'{$auth.name}',url:'{$auth.url}',jump:$("#jump").val(),index:index}
        parent.commonSubmit(data);

    }

</script>
{block name="jsBody"}<!-- 追加js -->{/block}
</body>
</html>
