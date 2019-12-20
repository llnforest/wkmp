{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <div class="layui-form-item">
        <label class="layui-form-label">酒品名称</label>
        <div class="layui-input-block">
            <input type="text" name="wine_name" value="{$info.wine_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入酒品名称" class="layui-input" readonly>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label require-mark">详情图</label>
        <div class="layui-input-block">
            <div class="img-wrap">
                {if isset($imgList)}
                {foreach $imgList as $item}
                <div class="img-block">
                    <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'winexqt'])}'}">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                        <input class="image" type="hidden" name="img" value="{$item.img??''}">
                        <img class="mini-image" data-path="__ImagePath__" src="__ImagePath__{$item.img}">
                    </button>
                    <input type="text" class="form-control img-sort" placeholder="排序" value="{$item.sort??''}">
                    <button class="layui-btn layui-btn-primary layui-btn-sm img-delete">
                        <i class="layui-icon">&#xe640;</i>
                    </button>
                </div>
                {/foreach}
                {/if}
                <div class="img-block">
                    <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'winexqt'])}'}">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                        <input class="image" type="hidden" name="img" value="">
                        <img class="mini-image hidden" data-path="__ImagePath__" src="">
                    </button>
                    <input type="text" class="form-control img-sort" placeholder="排序">
                    <button class="layui-btn layui-btn-primary layui-btn-sm img-delete">
                        <i class="layui-icon">&#xe640;</i>
                    </button>
                </div>

            </div>
            <div class="img-block clone">
                <button name="image" type="button" class="layui-btn upload" lay-data="{'url': '{:url('admin/upload/image',['type'=>'winexqt'])}'}">
                    <i class="layui-icon">&#xe67c;</i>上传图片
                    <input class="image" type="hidden" name="img" value="">
                    <img class="mini-image hidden" data-path="__ImagePath__" src="">
                </button>
                <input type="text" class="form-control img-sort" placeholder="排序">
                <button class="layui-btn layui-btn-primary layui-btn-sm img-delete">
                    <i class="layui-icon">&#xe640;</i>
                </button>
            </div>
            <div class="add-img-btn">
                <i class="layui-icon">&#xe654;</i>
            </div>
            <span class="layui-tx-red">(图片建议大小 750*X)</span>
        </div>
    </div>

{/block}

{block name="jsBody"}
<script>
    $(function(){
        //多图上传
        $(".add-img-btn").click(function(){
            var _clone = $(".clone").clone(true,true).removeClass("clone");
            $(".img-wrap").append(_clone);
            return false;
        })

        $(".img-delete").click(function(){
            $(this).parents('.img-block').remove();
        })
    })
</script>
{/block}
