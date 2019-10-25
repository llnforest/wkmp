{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">配置编码</label>
    <div class="layui-input-inline">
        <input name="config_code" value="{:input('config_code')}" autocomplete="off" class="layui-input" type="text" placeholder="配置编码">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">配置名称</label>
    <div class="layui-input-inline">
        <input name="config_name" value="{:input('config_name')}" autocomplete="off" class="layui-input" type="text" placeholder="配置名称">
    </div>
</div>
{/block}
{block name="jsBody"}
<script>
    //修改配置值
    function col4(obj){
        obj.menu_url = "{:str_replace('index','edit',$auth.url)}";
        obj.menu_name = '修改配置数值';
        obj.confirm = false;
        commonAjax(obj,{id:obj.data.col0,config_value:obj.value},false,true)
    }

    //清除缓存
    function clearCache(obj){
        obj.msg = false;
        commonAjax(obj,{},false);
    }

</script>
{/block}