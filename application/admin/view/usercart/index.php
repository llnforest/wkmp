{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">用户ID</label>
    <div class="layui-input-inline">
        <input name="user_id" value="{$user_id??''}" autocomplete="off" class="layui-input" type="text" placeholder="用户ID">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">会员姓名</label>
    <div class="layui-input-inline">
        <input name="name" value="{$name??''}" autocomplete="off" class="layui-input" type="text" placeholder="会员姓名">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">手机号码</label>
    <div class="layui-input-inline">
        <input name="phone" value="{$phone??''}" autocomplete="off" class="layui-input" type="text" placeholder="手机号码">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">酒品名称</label>
    <div class="layui-input-inline">
        <input name="wine_name" value="{$wine_name??''}" autocomplete="off" class="layui-input" type="text" placeholder="酒品名称">
    </div>
</div>
<div class="layui-inline">
    {tag:select label="上下架" name="status" inline="inline" code="upDown"  default="true" search="true"/}
</div>
<div class="layui-inline">
    <label class="layui-form-label">加入时间</label>
    <div class="layui-input-inline">
        <input name="create_start" value="{:input('create_start')}" placeholder="加入起始日期" readonly class="date-time date-start layui-input laydate-icon"  type="text">
    </div>
    <div class="layui-input-inline">
        <input name="create_end" value="{:input('create_end')}" placeholder="加入结束日期" readonly class="date-time date-end layui-input laydate-icon"  type="text">
    </div>
</div>
{/block}
{block name="jsBody"}

<script>


</script>
{/block}