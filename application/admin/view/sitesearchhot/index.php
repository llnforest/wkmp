{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">热搜关键词</label>
    <div class="layui-input-inline">
        <input name="keywords" value="{:input('keywords')}" autocomplete="off" class="layui-input" type="text" placeholder="热搜关键词">
    </div>
</div>
{/block}
{block name="jsBody"}
<script>


</script>
{/block}