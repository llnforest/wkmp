{layout name="template/listTpl" /}

{extend name="template/listTpl" /}

{block name="headBody"}{/block}
{block name="queryBody"}
<div class="layui-inline">
    <label class="layui-form-label">酒品名称</label>
    <div class="layui-input-inline">
        <input name="wine_name" value="{:input('wine_name')}" autocomplete="off" class="layui-input" type="text" placeholder="酒品名称">
    </div>
</div>

<div class="layui-inline">
    {tag:select label="上下架" name="status" inline="inline" code="upDown"  default="true" search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="首页推荐" name="is_recommend" inline="inline" code="isTrue"  default="true" search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="品牌名称" name="brand_id" inline="inline" sql="select brand_name,id from pin_wine_brand order by sort asc,create_time desc"  default="true" value="$brand_id"  search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="酒品系列" name="wine_style" inline="inline" code="wineStyle"  default="true" search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="酒品分类" name="wine_cate" inline="inline" code="wineCate"  default="true" search="true"/}
</div>
<div class="layui-inline">
    {tag:select label="包装规格" name="wine_size" inline="inline" code="wineSize"  default="true" search="true"/}
</div>
{/block}
{block name="jsBody"}
<script type="text/html" id="imgTpl">
    <img class="list-mini-image" src="{{ d.col5 != "" ?  '__ImagePath__'+d.col5 : '' }}">
</script>
<script type="text/html" id="statusTpl2">
    <input type="checkbox" name="dataFlag" lay-skin="switch" lay-text="上架|下架" lay-filter="dataFlag" {{ d.col2 == '1' ? 'checked' : '' }} value="{{ d.col0 }}">
</script>
<script type="text/html" id="statusTpl3">
    <input type="checkbox" name="dataFlag" lay-skin="switch" lay-text="推荐|否" lay-filter="dataFlag" {{ d.col3 == '1' ? 'checked' : '' }} value="{{ d.col0 }}">
</script>
<script>


</script>
{/block}