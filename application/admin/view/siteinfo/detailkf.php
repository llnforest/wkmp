{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <div class="layui-form-item">
        <label class="layui-form-label">客服头像</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'info'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="kf_head_img" lay-verify="required" value="{$info.kf_head_img??''}">
                <img class="mini-image {$info.kf_head_img?'':'hidden'}" data-path="__ImagePath__" src="{$info.kf_head_img?'__ImagePath__'.$info.kf_head_img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 252*234)</span>
        </div>
    </div>
        <div class="layui-form-item">
            <label class="layui-form-label">客服名称</label>
            <div class="layui-input-block">
                <input type="text" name="kf_name" value="{$info.kf_name??''}" placeholder="请输入客服名称"  lay-verify="required" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">客服电话</label>
            <div class="layui-input-block">
                <input type="text" name="kf_phone" value="{$info.kf_phone??''}" placeholder="请输入客服电话"  lay-verify="required" class="layui-input">
            </div>
        </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客服二维码</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'info'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="kf_qr_img" lay-verify="required" value="{$info.kf_qr_img??''}">
                <img class="mini-image {$info.kf_qr_img?'':'hidden'}" data-path="__ImagePath__" src="{$info.kf_qr_img?'__ImagePath__'.$info.kf_qr_img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 252*234)</span>
        </div>
    </div>
{/block}

{block name="jsBody"}

{/block}
