{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">商家名称</label>
    <div class="layui-input-inline">
        <input name="shop_name" value="{:input('shop_name')}" autocomplete="off" class="layui-input" type="text" placeholder="商家名称">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">联系方式</label>
    <div class="layui-input-inline">
        <input name="phone" value="{:input('phone')}" autocomplete="off" class="layui-input" type="text" placeholder="联系方式">
    </div>
</div>
{/block}
{block name="jsBody"}
<script type="text/html" id="imgTpl">
    <img class="list-mini-image" src="{{ d.col2 != "" ?  '__ImagePath__'+d.col2 : '' }}">
</script>
<script>


</script>
{/block}