{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
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
    {tag:select label="奖励类型" name="type" inline="inline" code="profitType"  default="true" search="true"/}
</div>
<div class="layui-inline">
    <label class="layui-form-label">奖励时间</label>
    <div class="layui-input-inline">
        <input name="create_start" value="{:input('create_start')}" placeholder="奖励起始日期" readonly class="date-time date-start layui-input laydate-icon"  type="text">
    </div>
    <div class="layui-input-inline">
        <input name="create_end" value="{:input('create_end')}" placeholder="奖励结束日期" readonly class="date-time date-end layui-input laydate-icon"  type="text">
    </div>
</div>
{/block}
{block name="jsBody"}
<script type="text/html" id="combineTpl">
    {{ d.col6 }}({{ d.col7 }})
</script>

<script>


</script>
{/block}