{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">用户姓名</label>
    <div class="layui-input-inline">
        <input name="contact_name" value="{$contact_name??''}" autocomplete="off" class="layui-input" type="text" placeholder="用户姓名">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">手机号码</label>
    <div class="layui-input-inline">
        <input name="contact_phone" value="{$contact_phone??''}" autocomplete="off" class="layui-input" type="text" placeholder="手机号码">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">邀请人姓名</label>
    <div class="layui-input-inline">
        <input name="name" value="{$name??''}" autocomplete="off" class="layui-input" type="text" placeholder="邀请人姓名">
    </div>
</div>
<div class="layui-inline">
    <label class="layui-form-label">邀请人号码</label>
    <div class="layui-input-inline">
        <input name="phone" value="{$phone??''}" autocomplete="off" class="layui-input" type="text" placeholder="邀请人号码">
    </div>
</div>
<div class="layui-inline">
    {tag:select label="订单状态" name="status" inline="inline" code="orderStatus"  default="true" search="true"/}
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
<div class="layui-inline">
    <label class="layui-form-label">最后操作时间</label>
    <div class="layui-input-inline">
        <input name="update_start" value="{:input('update_start')}" placeholder="操作起始日期" readonly class="date-time date-start layui-input laydate-icon"  type="text">
    </div>
    <div class="layui-input-inline">
        <input name="update_end" value="{:input('update_end')}" placeholder="操作结束日期" readonly class="date-time date-end layui-input laydate-icon"  type="text">
    </div>
</div>
{/block}
{block name="jsBody"}
<script type="text/html" id="combineTpl">
    {{# if(d.col4 != null){ }}
    {{ d.col4 }}-{{ d.col5 }}-{{ d.col6}}
    {{# } }}
</script>
{assign name="bar" value="$barButs|json_decode=true"}
<script type="text/html" id="listBarTool">
    {{# if(d.col13 == 0){ }}

    {foreach  $bar as $item}
    {if in_array($item.id,[111,113])}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/if}
    {/foreach}

    {{# }else if(d.col13 == 1){ }}

    {foreach  $bar as $item}
    {if in_array($item.id,[112,113])}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/if}
    {/foreach}

    {{# }else if(d.col13 == 2){ }}

    {foreach  $bar as $item}
    {if in_array($item.id,[110])}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/if}
    {/foreach}

    {{# }else if(d.col13 == 3){ }}
    {{# } }}
</script>
<script>
    //收货地址按钮
    function showAddress(obj){
        var data = obj.data;
        window.location.href='__ADMINPATH__' +obj.menu_url+"/user_id/"+data.col0;
    }

</script>
{/block}