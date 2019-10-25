{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <div class="layui-form-item">
        <label class="layui-form-label">配置编码</label>
        <div class="layui-input-block">
            <input type="text" name="config_code" value="{$info.config_code??''}" autocomplete="off" lay-verify="required" placeholder="请输入配置编码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >配置名称</label>
        <div class="layui-input-block">
            <input type="text" name="config_name" value="{$info.config_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入配置名称" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >配置数值</label>
        <div class="layui-input-block">
            <input type="text" name="config_value" value="{$info.config_value??''}" autocomplete="off" lay-verify="required" placeholder="请输入配置数值" class="layui-input" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >配置单位</label>
        <div class="layui-input-block">
            <input type="text" name="units" value="{$info.units??''}" autocomplete="off" placeholder="请输入配置单位" class="layui-input" >
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
