{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">字典名称</label>
    <div class="layui-input-inline">
        <input name="dict_name" value="{:input('dict_name')}" autocomplete="off" class="layui-input" type="text" placeholder="字典名称">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">字典编码</label>
    <div class="layui-input-inline">
        <input name="dict_code" value="{:input('dict_code')}" autocomplete="off" class="layui-input" type="text" placeholder="字典编码">
    </div>
</div>
{/block}
{block name="jsBody"}
<script>
    //字典参数按钮
    function showValue(obj){
        var data = obj.data;
        window.location.href='__ADMINPATH__' +obj.menu_url+"/dict_id/"+data.col0;
    }

</script>
{/block}