{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    {if !isset($info)}<input type="hidden" name="status" value="0"/>{/if}
    <div class="layui-form-item">
        <label class="layui-form-label">会员姓名</label>
        <div class="layui-input-block">
            <input type="text" name="name" value="{$info.name??''}" autocomplete="off" lay-verify="required" placeholder="请输入会员姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机号码</label>
        <div class="layui-input-block">
            <input type="text" name="phone" value="{$info.phone??''}" autocomplete="off" lay-verify="required" placeholder="请输入手机号码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        {tag:checkbox label="会员状态" name="status" skin="switch" value="1" text="正常|禁用" default="$info.status"  verify="required"/}
    </div>
{/block}

{block name="jsBody"}

{/block}
