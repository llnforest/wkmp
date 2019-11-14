{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    {if !isset($info)}
    <div class="layui-form-item">
        <label class="layui-form-label">用户ID</label>
        <div class="layui-input-block">
            <input type="text" name="user_id" value="{$info.user_id??''}" autocomplete="off" lay-verify="required" placeholder="请输入用户ID" class="layui-input">
        </div>
    </div>
    {/if}
    <div class="layui-form-item">
        <label class="layui-form-label">联系人名</label>
        <div class="layui-input-block">
            <input type="text" name="contact_name" value="{$info.contact_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入联系人名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联系电话</label>
        <div class="layui-input-block">
            <input type="text" name="contact_phone" value="{$info.contact_phone??''}" autocomplete="off" lay-verify="required" placeholder="请输入联系电话" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">收货地址</label>
        <div class="layui-input-block">
            <textarea name="address" placeholder="请输入收货地址" class="layui-textarea" lay-verify="required">{$info.address??''}</textarea>
        </div>
    </div>
{/block}

{block name="jsBody"}

{/block}
