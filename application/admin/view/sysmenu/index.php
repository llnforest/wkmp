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
<script type="text/html" id="statusTpl">
    <input type="checkbox" name="dataFlag" lay-skin="switch" lay-text="正常|停用" lay-filter="dataFlag" {{ d.col4 == '1' ? 'checked' : '' }} value="{{ d.col0 }}">
</script>
<script>
    //修改菜单名称
    function col3(obj){
        obj.menu_name = '修改菜单名称';
        editField(obj,{menu_name:obj.value})
    }
    //修改菜单地址
    function col8(obj){
        obj.menu_name = '修改菜单地址';
        editField(obj,{menu_url:obj.value})
    }
    //添加下级
    function addDown(obj){
        obj.menu_url += '/parent_id/'+obj.data.col0;
        commonOpen(obj)
    }
    //点击树
    function clickNode(obj){
        var nodeId = obj.param.nodeId;
        whereField.parent_id = nodeId;
        initFunc(true);
    }
</script>
{/block}