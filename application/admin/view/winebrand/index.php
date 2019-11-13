{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">品牌名称</label>
    <div class="layui-input-inline">
        <input name="brand_name" value="{:input('brand_name')}" autocomplete="off" class="layui-input" type="text" placeholder="品牌名称">
    </div>
</div>
{/block}
{block name="jsBody"}
<script type="text/html" id="imgTpl">
    <img class="list-mini-image" src="{{ d.col2 != "" ?  '__ImagePath__'+d.col2 : '' }}">
</script>
<script type="text/html" id="statusTpl">
    <input type="checkbox" name="dataFlag" lay-skin="switch" lay-text="正常|停用" lay-filter="dataFlag" {{ d.col4 == '1' ? 'checked' : '' }} value="{{ d.col0 }}">
</script>
<script>


</script>
{/block}