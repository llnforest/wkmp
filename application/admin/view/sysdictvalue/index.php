{layout name="template/listTpl" /}

{extend name="template/listTpl" /}
{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">字典参数</label>
    <div class="layui-input-inline">
        <input name="val_name" value="{:input('val_name')}" autocomplete="off" class="layui-input" type="text" placeholder="字典参数">
    </div>
</div>
<div class="layui-inline">
    {assign name="dict_id" value="$Request.param.dict_id"}
    {tag:select label="字典名称" name="dict_id" inline="inline" sql="select dict_name,id from sys_dict order by sort asc"  default="true" value="$dict_id"  search="true"/}
</div>
{/block}
{block name="jsBody"}
<script>
    function add(obj){
        obj.menu_url += '/dict_id/{$Request.param.dict_id}';
        commonOpen(obj);
    }

</script>
{/block}