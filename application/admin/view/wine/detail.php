{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <input type="hidden" name="status" value="0"/>
    <input type="hidden" name="is_recommend" value="0"/>

    <div class="layui-form-item">
        <label class="layui-form-label">酒品名称</label>
        <div class="layui-input-block">
            <input type="text" name="wine_name" value="{$info.wine_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入酒品名称" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">酒品封面</label>
        <div>
            <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'wine'])}'}">
                <i class="layui-icon">&#xe67c;</i>上传图片
                <input class="image" type="hidden" name="img" value="{$info.img??''}" lay-verify="required">
                <img class="mini-image {$info.img?'':'hidden'}" data-path="__ImagePath__" src="{$info.img?'__ImagePath__'.$info.img:''}">
            </button>
            <span class="layui-tx-red block">(图片建议大小 120*120)</span>
        </div>
    </div>
    <div class="layui-form-item">
        {tag:checkbox label="上下架" name="status" skin="switch" value="1" text="上架|下架" default="$info.status"  verify="required"/}
    </div>
    <div class="layui-form-item">
        {tag:checkbox label="首页推荐" name="is_recommend" skin="switch" value="1" text="是|否" default="$info.is_recommend"  verify="required"/}
    </div>

    <div class="layui-form-item">
        {tag:select label="品牌选择" name="brand_id" sql="select brand_name,id from pin_wine_brand order by sort asc,create_time desc"  value="$info.brand_id" verify="required"/}
    </div>
    <div class="layui-form-item">
        {tag:select label="酒品系列" name="wine_style" code="wineStyle" value="$info.wine_style"  verify="required"/}
    </div>
    <div class="layui-form-item">
        {tag:select label="酒品分类" name="wine_cate" code="wineCate" value="$info.wine_cate"  verify="required"/}
    </div>
    <div class="layui-form-item">
        {tag:select label="包装规格" name="wine_size" code="wineSize" value="$info.wine_size"  verify="required"/}
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">市场价</label>
        <div class="layui-input-block">
            <input type="text" name="mall_price" value="{$info.mall_price??''}" autocomplete="off" lay-verify="required" placeholder="请输入市场价" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">会员价</label>
        <div class="layui-input-block">
            <input type="text" name="vip_price" value="{$info.vip_price??''}" autocomplete="off" lay-verify="required" placeholder="请输入会员价" class="layui-input">
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
