{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    {if !isset($info)}<input type="hidden" name="status" value="0"/>{/if}
    <div class="layui-form-item">
        {tag:checkbox label="广告状态" name="status" skin="switch" value="1" text="正常|禁用" default="$info.status"/}
    </div>
    <div class="layui-form-item">
        {tag:select label="广告位" name="position_id" sql="select position_name,id from pin_site_banner_position order by sort asc"  value="$info.position_id" /}
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">广告图片</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'banner'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="img" value="{$info.img??''}" lay-verify="required">
                <img class="mini-image {$info.img?'':'hidden'}" data-path="__ImagePath__" src="{$info.img?'__ImagePath__'.$info.img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 252*234)</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label require-mark">广告标题</label>
        <div class="layui-input-block">
            <input type="text" name="title" value="{$info.title??''}" autocomplete="off" lay-verify="required" placeholder="请输入广告标题" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label" >链接地址</label>
        <div class="layui-input-block">
            <input type="text" name="url" value="{$info.url??''}" autocomplete="off" placeholder="请输入链接地址" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序号码</label>
        <div class="layui-input-block">
            <input type="text" name="sort" value="{$info.sort??''}" placeholder="请输入排序号码" class="layui-input">
        </div>
    </div>
{/block}

{block name="jsBody"}

{/block}
