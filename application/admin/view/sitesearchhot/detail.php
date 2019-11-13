{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <div class="layui-form-item">
        <label class="layui-form-label">热搜关键词</label>
        <div class="layui-input-block">
            <input type="text" name="keywords" value="{$info.keywords??''}" autocomplete="off" lay-verify="required" placeholder="请输入热搜关键词" class="layui-input">
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
