{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    {if !isset($info)}<input type="hidden" name="status" value="0"/>{/if}

    <div class="layui-form-item">
        <label class="layui-form-label">品牌图片</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'winebrand'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="img" value="{$info.img??''}" lay-verify="required">
                <img class="mini-image {$info.img?'':'hidden'}" data-path="__ImagePath__" src="{$info.img?'__ImagePath__'.$info.img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 120*120)</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">品牌名称</label>
        <div class="layui-input-block">
            <input type="text" name="brand_name" value="{$info.brand_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入品牌名称" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        {tag:checkbox label="状态" name="status" skin="switch" value="1" text="正常|禁用" default="$info.status"  verify="required"/}
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
