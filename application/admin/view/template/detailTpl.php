
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
        //监听提交
        form.on('submit(submitForm)', function(data){
            if(data.field.status == undefined && $('[name="status"]').val() == 0) data.field.status = 0;
            submitForm(data);
            return false;
        });

        //关闭自身弹出层
        $("#closeBut").click(function(){
            var index= window.parent.layer.getFrameIndex(window.name);
            window.parent.layer.close(index);
        });

        //监听状态操作
        form.on('switch(status)', function(obj){
            $(this).val(obj.elem.checked?1:0);
        });
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
