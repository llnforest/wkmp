{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}
<style>
    .layui-layer-dialog .layui-form-label{
        width:auto;
    }
    .layui-layer-dialog .layui-input-block {
        margin-left: 100px;
    }
</style>
{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">订单编号</label>
    <div class="layui-input-inline">
        <input name="id" value="{$id??''}" autocomplete="off" class="layui-input" type="text" placeholder="订单编号">
    </div>
</div>
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
    <label class="layui-form-label">快递单号</label>
    <div class="layui-input-inline">
        <input name="express" value="{$express??''}" autocomplete="off" class="layui-input" type="text" placeholder="快递单号">
    </div>
</div>
<div class="layui-inline">
    {tag:select label="配送类型" name="exress_type" inline="inline" code="expressType"  default="true" search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="订单状态" name="status" inline="inline" code="orderStatus"  default="true" search="true"/}
</div>
<div class="layui-inline">
    <label class="layui-form-label">下单时间</label>
    <div class="layui-input-inline">
        <input name="create_start" value="{:input('create_start')}" placeholder="下单起始日期" readonly class="date-time date-start layui-input laydate-icon"  type="text">
    </div>
    <div class="layui-input-inline">
        <input name="create_end" value="{:input('create_end')}" placeholder="下单结束日期" readonly class="date-time date-end layui-input laydate-icon"  type="text">
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
{assign name="bar" value="$barButs|json_decode=true"}
<script type="text/html" id="listBarTool">
    {{# if(d.col4 == 0){ }}

    {foreach  $bar as $item}
    {if in_array($item.id,[126,129,130])}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/if}
    {/foreach}

    {{# }else if(d.col4 == 1){ }}

    {foreach  $bar as $item}
    {if in_array($item.id,[127,129,130])}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/if}
    {/foreach}

    {{# }else if(d.col4 == 2){ }}

    {foreach  $bar as $item}
    {if in_array($item.id,[128,129,130])}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/if}
    {/foreach}

    {{# }else if(d.col4 == 3){ }}

    {foreach  $bar as $item}
    {if in_array($item.id,[110,130])}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/if}
    {/foreach}

    {{# }else if(d.col4 == 4){ }}

    {foreach  $bar as $item}
    {if in_array($item.id,[130])}
    <a class="layui-btn layui-btn-xs" style="background-color:{$item.btn_css}" data-url="{$item.menu_url}" lay-event="{$item.btn_func}"> {$item.menu_icon|raw}{$item.menu_name}</a>
    {/if}
    {/foreach}

    {{# } }}
</script>
<script>
    //修改配送地址
    function col10(obj){
        obj.menu_name = '修改地址说明';
        editField(obj,{address_info:obj.value})
    }
    //修改后台备注
    function col13(obj){
        obj.menu_name = '修改后台备注';
        editField(obj,{remark:obj.value})
    }

    //发货
    function setPay(obj){
        commonAjax(obj,{id:obj.data.col0});
    }

    //发货
    function setSend(obj){
        sendConfirm(obj,{id:obj.data.col0});
    }

    function sendConfirm(obj,data,refresh,fail,cancel){
        refresh = refresh == false ? false: true;
        fail = fail || false;
        if(obj.confirm == false){
            sendAjax(obj,data,refresh,fail);
        }else{
            var index = layer.confirm('请选择该订单（'+data.id+'）发货的方式？',{
                btn:['代叫达达','快递发货','直接发货','取消发货'],
                area:['440px','180px'],
                btn4:function(index,layero){
                    //取消发货
                },
                btn3:function(index,layero){
                    //直接发货
                    commonAjax(obj,data);
                }
            },function(index,layero){

                sendAjax(
                    {menu_url:'admin/orderwine/makeorderfordada'},{type:0,id:data.id},true,false,function (d){
                        if(d.code == '0'){
                            layer.confirm(
                                '<form class="layui-form">'+
                                '<div class="layui-form-item">'+
                                '{tag:select label="取件地址" name="shop_no" sql="select shop_name,shop_no from pin_site_shop order by sort asc,create_time desc"  value="$shop_no" verify="required"/}'+
                                '</div>'+
                                '<div class="layui-form-item">'+
                                '<label class="layui-form-label" >收件人姓名</label>'+
                                '<div class="layui-input-block">'+
                                '<input type="text" name="user_name" value="'+d.data.user_name+'" autocomplete="off" lay-verify="required" placeholder="请输入收件人姓名" class="layui-input" >'+
                            '</div>' +
                            '</div>' +

                                '<div class="layui-form-item">'+
                                '<label class="layui-form-label" >收件人电话</label>'+
                                '<div class="layui-input-block">'+
                                '<input type="text" name="user_phone" value="'+d.data.user_phone+'" autocomplete="off" lay-verify="required" placeholder="请输入收件人电话" class="layui-input" >'+
                                '</div>' +
                                '</div>' +

                                '<div class="layui-form-item">'+
                                '<label class="layui-form-label" >收件人地址</label>'+
                                '<div class="layui-input-block">'+
                                '<input type="text" name="user_address" value="'+d.data.user_address+'" autocomplete="off" lay-verify="required" placeholder="请输入收件人地址" class="layui-input" >'+
                                '</div>' +
                                '</div>' +
                                '</form>',
                                {
                                    btn:['查看达达费用','取消'],
                                    area:['440px','370px'],
                                    title:'订单（'+data.id+'）地址信息'
                                },
                                function(index){
                                    //查看达达费用

                                },
                                function(index){
                                    //取消
                                }
                            );

                                layui.use(['form'],function(){
                                    var form = layui.form;
                                    form.render('select');
                                })

                        }else{
                            layer.msg(d.msg,{offset:offsetTop});
                            initFunc(false);
                        }

                    }
                );
                //代叫达达

            },function(index){
                //快递发货

                console.log(2);

            });
        }
    }

    //完成
    function setSuccess(obj){
        commonAjax(obj,{id:obj.data.col0});
    }
    //取消
    function setCancel(obj){
        commonAjax(obj,{id:obj.data.col0});
    }
</script>
{/block}