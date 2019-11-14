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
    <label class="layui-form-label">搜索关键词</label>
    <div class="layui-input-inline">
        <input name="keywords" value="{$keywords??''}" autocomplete="off" class="layui-input" type="text" placeholder="搜索关键词">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">搜索时间</label>
    <div class="layui-input-inline">
        <input name="create_start" value="{:input('create_start')}" placeholder="搜索起始日期" readonly class="date-time date-start layui-input laydate-icon"  type="text">
    </div>
    <div class="layui-input-inline">
        <input name="create_end" value="{:input('create_end')}" placeholder="搜索结束日期" readonly class="date-time date-end layui-input laydate-icon"  type="text">
    </div>
</div>
{/block}
{block name="jsBody"}

<script>


</script>
{/block}