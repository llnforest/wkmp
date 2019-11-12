{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="headBody"}
<link rel="stylesheet" href="__ADMINSTATIC__/layui_ext/formSelects/formSelects-v4.css">
{/block}
{block name="formBody"}
    <div class="layui-form-item">
        <label class="layui-form-label" >用户名称</label>
        <div class="layui-input-block">
            <input type="text" name="nickname" value="{$info.nickname??''}" autocomplete="off" lay-verify="required" placeholder="请输入管理员名称" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >登录账户</label>
        <div class="layui-input-block">
            <input type="text" name="name" value="{$info.name??''}" autocomplete="off" lay-verify="required" placeholder="请输入登录账户" class="layui-input">
        </div>
    </div>
    {if !isset($info.password)}
    <div class="layui-form-item">
        <label class="layui-form-label" >登录密码</label>
        <div class="layui-input-block">
            <input type="text" name="password" value="{$info.password??''}" autocomplete="off" lay-verify="required" placeholder="请输入登录密码" class="layui-input">
        </div>
    </div>
    {/if}
    <div class="layui-form-item">
        <label class="layui-form-label" >角色选择</label>
        <div class="layui-input-block">
            <select name="roleIds" xm-select="roleIds">

            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >手机号码</label>
        <div class="layui-input-block">
            <input type="text" name="phone" value="{$info.phone??''}" autocomplete="off" lay-verify="required" placeholder="请输入手机号码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >电子邮箱</label>
        <div class="layui-input-block">
            <input type="text" name="email" value="{$info.email??''}" autocomplete="off" placeholder="请输入电子邮箱" class="layui-input">
        </div>
    </div>
{/block}

{block name="jsBody"}
    <script>
        //加载js
        layui.config({
            base: '__ADMINSTATIC__/layui_ext/formSelects/'
        }).extend({
            formSelects: 'formSelects-v4'
        });
        //加载模块选择表单
        layui.use(['jquery', 'formSelects'], function(){
            var formSelects = layui.formSelects;
            layui.formSelects.config('roleIds', {
                searchUrl: "{:url('admin/role/getRoleListByUser',['user_id'=>isset($info.id)?$info.id:''])}"
                ,success: function(id, url, searchVal, result){
                    // var data = result.data;
                    // if(!isEmpty(data)){
                    //     for(var i=0;i<data.length;i++){
                    //         var row = data[i];
                    //         if(row.selected == 1){
                    //             formSelects.value('roleIds',row.value );
                    //         }
                    //     }
                    // }
                }
            });

            formSelects.on('roleIds', function(id, vals, val, isAdd, isDisabled){
                formSelects.value('roleIds', 'valStr');
            }, true);


        });

    </script>

{/block}
