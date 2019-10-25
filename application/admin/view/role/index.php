{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">角色名称</label>
    <div class="layui-input-inline">
        <input name="name" value="{:input('name')}" autocomplete="off" class="layui-input" type="text" placeholder="角色名称">
    </div>
</div>
{/block}
{block name="jsBody"}
{assign name="bar" value="$barButs|json_decode=true"}
<script type="text/html" id="listBarTool">
    {{# if(d.col0 != 1){ }}
    {foreach  $bar as $item}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/foreach}
    {{# } }}
</script>
<script>
    //字典参数按钮
    function auth(obj){
        obj.menu_url += "/id/"+obj.data.col0;
        commonOpen(obj,false);
    }
</script>
{/block}