{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    {tag:select label="广告位" name="position_id" inline="inline" sql="select position_name,id from pin_site_banner_position order by sort asc,create_time desc"  default="true" value="$position_id"  search="true"/}
</div>
<div class="layui-inline">
    <label class="layui-form-label">广告标题</label>
    <div class="layui-input-inline">
        <input name="title" value="{:input('title')}" autocomplete="off" class="layui-input" type="text" placeholder="广告标题">
    </div>
</div>
{/block}
{block name="jsBody"}
<script type="text/html" id="imgTpl">
    <img class="list-mini-image" src="{{ d.col4 != "" ?  '__ImagePath__'+d.col4 : '' }}">
</script>
<script type="text/html" id="statusTpl">
    <input type="checkbox" name="dataFlag" lay-skin="switch" lay-text="正常|停用" lay-filter="dataFlag" {{ d.col2 == '1' ? 'checked' : '' }} value="{{ d.col0 }}">
</script>
<script>
    console.log('ok');
    //修改链接地址
    function col6(obj){
        obj.menu_name = '修改链接地址';
        editField(obj,{'url':obj.value})
    }
</script>
{/block}