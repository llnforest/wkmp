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
    {tag:select label="会员等级" name="level" inline="inline" code="userLevel"  default="true" search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="会员状态" name="status" inline="inline" code="status"  default="true" search="true"/}
</div>
<div class="layui-inline">
    <label class="layui-form-label">入会时间</label>
    <div class="layui-input-inline">
        <input name="join_start" value="{:input('join_start')}" placeholder="入会起始日期" readonly class="date-time date-start layui-input laydate-icon"  type="text">
    </div>
    <div class="layui-input-inline">
        <input name="join_end" value="{:input('join_end')}" placeholder="入会结束日期" readonly class="date-time date-end layui-input laydate-icon"  type="text">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">创建时间</label>
    <div class="layui-input-inline">
        <input name="create_start" value="{:input('create_start')}" placeholder="创建起始日期" readonly class="date-time date-start layui-input laydate-icon"  type="text">
    </div>
    <div class="layui-input-inline">
        <input name="create_end" value="{:input('create_end')}" placeholder="创建结束日期" readonly class="date-time date-end layui-input laydate-icon"  type="text">
    </div>
</div>
{/block}
{block name="jsBody"}
<script type="text/html" id="imgTpl">
    <img class="list-mini-image" src="{{ d.col1 != "" ?  d.col1 : '' }}">
</script>
<script type="text/html" id="statusTpl">
    <input type="checkbox" name="dataFlag" lay-skin="switch" lay-text="正常|停用" lay-filter="dataFlag" {{ d.col6 == '1' ? 'checked' : '' }} value="{{ d.col0 }}">
</script>
<script>
    //收货地址按钮
    function showAddress(obj){
        var data = obj.data;
        window.location.href='__ADMINPATH__' +obj.menu_url+"/user_id/"+data.col0;
    }
    //收益纪录按钮
    function showProfit(obj){
        var data = obj.data;
        window.location.href='__ADMINPATH__' +obj.menu_url+"/user_id/"+data.col0;
    }
    //提现记录按钮
    function showTake(obj){
        var data = obj.data;
        window.location.href='__ADMINPATH__' +obj.menu_url+"/user_id/"+data.col0;
    }

</script>
{/block}