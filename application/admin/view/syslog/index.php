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
    <label class="layui-form-label">操作菜单</label>
    <div class="layui-input-inline">
        <input name="operate_menu" value="{:input('operate_menu')}" autocomplete="off" class="layui-input" type="text" placeholder="操作菜单">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">操作名称</label>
    <div class="layui-input-inline">
        <input name="operate_name" value="{:input('operate_name')}" autocomplete="off" class="layui-input" type="text" placeholder="操作名称">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">日志备注</label>
    <div class="layui-input-inline">
        <input name="log" value="{:input('log')}" autocomplete="off" class="layui-input" type="text" placeholder="日志备注">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">操作时间</label>
    <div class="layui-input-inline">
        <input name="start" value="{:input('start')}" placeholder="起始日期" readonly class="date-time date-start layui-input laydate-icon"  type="text">
    </div>
    <div class="layui-input-inline">
        <input name="end" value="{:input('end')}" placeholder="结束日期" readonly class="date-time date-end layui-input laydate-icon"  type="text">
    </div>
</div>
{/block}
{block name="jsBody"}
<script>
    renderDatePicker();//渲染时间
</script>
{/block}