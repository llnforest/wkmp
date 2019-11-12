{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <div class="layui-form-item">
        <label class="layui-form-label" >字典名称</label>
        <div class="layui-input-block">
            <input type="text" name="dict_name" value="{$info.dict_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入字典名称" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">字典编码</label>
        <div class="layui-input-block">
            <input type="text" name="dict_code" value="{$info.dict_code??''}" autocomplete="off" lay-verify="required" placeholder="请输入字典编码" class="layui-input">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">排序号码</label>
        <div class="layui-input-block">
            <input type="text" name="sort" value="{$info.sort??''}" placeholder="请输入排序号码" class="layui-input">
        </div>
    </div>


    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注说明</label>
        <div class="layui-input-block">
            <textarea name="remark" placeholder="请输入备注说明" class="layui-textarea">{$info.remark??''}</textarea>
        </div>
    </div>

{/block}

{block name="jsBody"}

{/block}
