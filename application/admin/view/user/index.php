{layout name="template/listTpl" /}

{extend name="template/listTpl" /}
{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">用户名称</label>
    <div class="layui-input-inline">
        <input name="nickname" value="{:input('nickname')}" autocomplete="off" class="layui-input" type="text" placeholder="用户名称">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">登录账户</label>
    <div class="layui-input-inline">
        <input name="name" value="{:input('name')}" autocomplete="off" class="layui-input" type="text" placeholder="登录账户">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">手机号码</label>
    <div class="layui-input-inline">
        <input name="phone" value="{:input('phone')}" autocomplete="off" class="layui-input" type="text" placeholder="手机号码">
    </div>
</div>
<div class="layui-inline">
    {tag:select label="状态" name="status" inline="inline" code="status"  default="true"/}
</div>
{/block}
{block name="jsBody"}
<script type="text/html" id="statusTpl">
    <input type="checkbox" name="dataFlag" lay-skin="switch" lay-text="正常|停用" lay-filter="dataFlag" {{ d.col3 == '1' ? 'checked' : '' }} value="{{ d.col0 }}">
</script>
<script>
    function resetPassword(obj){
        commonAjax(obj,{id:obj.data.col0});
    }
</script>
{/block}