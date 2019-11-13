{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}

    <div class="layui-form-item">
        <label class="layui-form-label">主标题</label>
        <div class="layui-input-block">
            <input type="text" name="title" value="{$info.title??''}" autocomplete="off" lay-verify="required" placeholder="请输入主标题" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">副标题</label>
        <div class="layui-input-block">
            <input type="text" name="sub_title" value="{$info.sub_title??''}" autocomplete="off" lay-verify="required" placeholder="请输入副标题" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">简介</label>
        <div class="layui-input-block">
            <textarea name="description" placeholder="请输入备注说明" class="layui-textarea"  lay-verify="required">{$info.description??''}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">主图</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'shop'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="img" lay-verify="required" value="{$info.img??''}">
                <img class="mini-image {$info.img?'':'hidden'}" data-path="__ImagePath__" src="{$info.img?'__ImagePath__'.$info.img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 252*234)</span>
        </div>
    </div>
    <hr class="layui-bg-green">
    <div class="layui-form-item">
        <label class="layui-form-label">第一张图</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'info'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="fir_img" lay-verify="required" value="{$info.fir_img??''}">
                <img class="mini-image {$info.fir_img?'':'hidden'}" data-path="__ImagePath__" src="{$info.fir_img?'__ImagePath__'.$info.fir_img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 252*234)</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">第一张图主标题</label>
        <div class="layui-input-block">
            <input type="text" name="fir_name" value="{$info.fir_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入第一张图主标题" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label" >第一张图副标题</label>
        <div class="layui-input-block">
            <input type="text" name="fir_name_eng" value="{$info.fir_name_eng??''}" autocomplete="off" lay-verify="required" placeholder="请输入第一张图副标题" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">第二张图</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'info'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="sec_img" lay-verify="required" value="{$info.sec_img??''}">
                <img class="mini-image {$info.sec_img?'':'hidden'}" data-path="__ImagePath__" src="{$info.sec_img?'__ImagePath__'.$info.sec_img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 252*234)</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">第二张图主标题</label>
        <div class="layui-input-block">
            <input type="text" name="sec_name" value="{$info.sec_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入第二张图主标题" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >第二张图副标题</label>
        <div class="layui-input-block">
            <input type="text" name="sec_name_eng" value="{$info.sec_name_eng??''}" autocomplete="off" lay-verify="required" placeholder="请输入第二张图副标题" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">第三张图</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'info'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="thr_img" lay-verify="required" value="{$info.thr_img??''}">
                <img class="mini-image {$info.thr_img?'':'hidden'}" data-path="__ImagePath__" src="{$info.thr_img?'__ImagePath__'.$info.thr_img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 252*234)</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">第三张图主标题</label>
        <div class="layui-input-block">
            <input type="text" name="thr_name" value="{$info.thr_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入第三张图主标题" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >第三张图副标题</label>
        <div class="layui-input-block">
            <input type="text" name="thr_name_eng" value="{$info.thr_name_eng??''}" autocomplete="off" lay-verify="required" placeholder="请输入第三张图副标题" class="layui-input" >
        </div>
    </div>
{/block}

{block name="jsBody"}

{/block}
