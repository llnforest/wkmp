{layout name="template/treeTpl" /}

{extend name="template/treeTpl" /}
{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">菜单名称</label>
    <div class="layui-input-inline">
        <input name="menu_name" value="{:input('menu_name')}" autocomplete="off" class="layui-input" type="text" placeholder="菜单名称">
    </div>
</div>
<div class="layui-inline">
    {tag:select label="菜单类型" name="menu_type" inline="inline" code="menuType"  default="true" search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="按钮类型" name="btn_type" inline="inline" code="btnType"  default="true" search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="日志级别" name="log_level" inline="inline" code="logLevel"  default="true" search="true"/}
</div>
{/block}
{block name="jsBody"}
<script>

    function addDown(obj){
        obj.menu_url += '/parent_id/'+obj.data.col0;
        commonOpen(obj)
    }

    function clickNode(obj){
        var nodeId = obj.param.nodeId;
        whereField.parent_id = nodeId;
        initFunc(true);
    }
</script>
{/block}