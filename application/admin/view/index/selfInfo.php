{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <div class="layui-form-item">
        <label class="layui-form-label" >用户名称</label>
        <div class="layui-input-block">
            <input type="text" name="nickname" value="{$info.nickname??''}" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >登录账户</label>
        <div class="layui-input-block">
            <input type="text" name="name" value="{$info.name??''}" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >角色选择</label>
        <div class="layui-input-block">
            <input type="text" name="role_name" value="{$info.role_name??''}" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >手机号码</label>
        <div class="layui-input-block">
            <input type="text" name="phone" value="{$info.phone??''}" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >电子邮箱</label>
        <div class="layui-input-block">
            <input type="text" name="email" value="{$info.email??''}" autocomplete="off" readonly class="layui-input">
        </div>
    </div>
{/block}

