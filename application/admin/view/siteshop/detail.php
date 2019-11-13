{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <div class="layui-form-item">
        <label class="layui-form-label">商家封面</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'shop'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="img"  lay-verify="required" value="{$info.img??''}">
                <img class="mini-image {$info.img?'':'hidden'}" data-path="__ImagePath__" src="{$info.img?'__ImagePath__'.$info.img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 252*234)</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商家名称</label>
        <div class="layui-input-block">
            <input type="text" name="shop_name" value="{$info.shop_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入商家名称" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label" >联系方式</label>
        <div class="layui-input-block">
            <input type="text" name="phone" value="{$info.phone??''}" autocomplete="off" lay-verify="required" placeholder="请输入联系方式" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >商家地址</label>
        <div class="layui-input-block">
            <input type="text" name="address" value="{$info.address??''}" autocomplete="off" lay-verify="required" placeholder="请输入商家地址" class="layui-input" >
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
