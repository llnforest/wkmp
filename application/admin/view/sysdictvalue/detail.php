{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <input type="hidden" name="val_color" value="{$info.val_color??''}"  placeholder="字体颜色" class="layui-input">
    <div class="layui-form-item">
        {tag:select label="字典名称" name="dict_id" sql="select dict_name,id from sys_dict order by sort asc"  value="$info.dict_id" /}
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >参数名称</label>
        <div class="layui-input-block">
            <input type="text" name="val_name" value="{$info.val_name??''}" autocomplete="off" lay-verify="required" placeholder="请输入参数名称" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >参数编码</label>
        <div class="layui-input-block">
            <input type="text" name="val_code" value="{$info.val_code??''}" autocomplete="off" lay-verify="required" placeholder="请输入参数编码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >字体颜色</label>
        <div class="layui-input-block">
            <div id="val_color"></div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">排序号码</label>
        <div class="layui-input-block">
            <input type="text" name="sort" value="{$info.sort??''}"  placeholder="请输入排序号嘛" autocomplete="off" class="layui-input">
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
    <script>
        layui.use(['colorpicker'], function(){
            var colorpicker = layui.colorpicker,
                $ = layui.jquery;

            //初始化按钮颜色选择器
            renderColorpicker();

            function renderColorpicker(){
                colorpicker.render({
                    elem: '#val_color'
                    ,color: $('[name="val_color"]').val() //设置默认色
                    ,predefine: true // 开启预定义颜色
                    ,done: function(color){
                        $('[name="val_color"]').val(color);
                    }
                });
            }
        });


    </script>

{/block}
