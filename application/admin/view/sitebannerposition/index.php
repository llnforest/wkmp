{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">广告位名称</label>
    <div class="layui-input-inline">
        <input name="position_name" value="{:input('position_name')}" autocomplete="off" class="layui-input" type="text" placeholder="广告位名称">
    </div>
</div>
{/block}
{block name="jsBody"}
<script>


</script>
{/block}