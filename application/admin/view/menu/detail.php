{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
    <input type="hidden" name="btn_css" value="{$info.btn_css??''}" />
    <input type="hidden" name="parent_id" value="{$info.parent_id??0}" />
    <div class="layui-form-item">
        <?php $info['menu_type'] = isset($info['menu_type'])?$info['menu_type']:'M'; ?>
        {tag:radio label="菜单类型" name="menu_type" code="menuType" value="info.menu_type" /}
    </div>
    <div class="layui-form-item">
        {tag:checkbox label="菜单状态" name="status" skin="switch" value="1" text="正常|隐藏" default="$info.status"/}
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" >菜单图标</label>
        <div class="layui-input-block">
            <input type="text" name="menu_icon" value="{$info.menu_icon??''}" placeholder="请选择图标" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-block">
            <input type="text" name="menu_name" value="{$info.menu_name??''}" lay-verify="required" placeholder="请输入名称" class="layui-input">
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">菜单URL</label>
        <div class="layui-input-block">
            <input type="text" name="menu_url" value="{$info.menu_url??''}" lay-verify="required" placeholder="请输入URL" class="layui-input">
        </div>
    </div>
    <div id="buttonTypeDocment" class="layui-form-item layui-hide">
        <div class="layui-inline">
            {tag:select label="按钮事件" name="btn_type" inline="inline" code="btnType" value="info.btn_type" style="width: 120px;" /}
        </div>
        <div class="layui-inline">
            {tag:select name="btn_event" inline="inline"  code="btnFunc" isDefault="false" value="info.btn_func" style="width: 120px;" /}
        </div>
        <div class="layui-inline" >
            <div class="layui-input-inline" style="width: 120px;">
                <input type="text" name="btn_func" value="{$info.btn_func??''}"  placeholder="JS调用事件名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div id="buttonCss"></div>
    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            {tag:select label="日志级别" name="log_level" code="logLevel" value="info.logLevel" /}
        </div>
        <div class="layui-inline" >
            <label class="layui-form-label">排序号码</label>
            <div class="layui-input-inline">
                <input type="text" name="sort" value="{$info.sort??''}" placeholder="请输入排序号" class="layui-input">
            </div>
        </div>
    </div>

    <div class="layui-form-item layui-hide">
        <label class="layui-form-label" >日志规则</label>
        <div class="layui-input-block">
            <input type="text" name="log_rule" value="{$info.log_rule??''}" placeholder="请输入日志规则" class="layui-input">
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
        layui.use(['form','colorpicker'], function(){
            var form = layui.form,
                colorpicker = layui.colorpicker,
                $ = layui.jquery;


            $(function(){
                var mv = '{$info.menu_type}';
                if(mv=='B'){
                    $('[name="menu_icon"]').parent().parent('.layui-form-item').removeClass('layui-hide');
                    $('#buttonTypeDocment').removeClass('layui-hide');
                }else{
                    $('#buttonTypeDocment').addClass('layui-hide');
                    $('[name="btn_css"]').val('');
                    $('[name="btn_type"]').val('');
                    if(mv == 'T' || mv == 'G'){
                        $('[name="menu_icon"]').val('');
                        $('[name="menu_icon"]').parent().parent('.layui-form-item').addClass('layui-hide');
                    }else{
                        $('[name="menu_icon"]').parent().parent('.layui-form-item').removeClass('layui-hide');
                    }
                }
                if(mv == 'B' || mv == 'G'){
                    $('[name="log_rule"]').parent().parent('.layui-form-item').removeClass('layui-hide');
                }else{
                    $('[name="log_rule"]').val('');
                }
                //初始化按钮颜色选择器
                renderColorpicker('{$info.btn_css?:'#009688'}');

            });

            //监听菜单类型单选按钮
            form.on('radio(menu_type)', function(data){
                //如果是菜单
                if(data.value=='B'){
                    $('[name="menu_icon"]').parent().parent('.layui-form-item').removeClass('layui-hide');
                    $('#buttonTypeDocment').removeClass('layui-hide');
                }else{
                    $('#buttonTypeDocment').addClass('layui-hide');
                    $('[name="btn_css"]').val('');
                    $('[name="btn_type"]').val('');
                    if(data.value == 'T' || data.value == 'G'){
                        $('[name="menu_icon"]').parent().parent('.layui-form-item').addClass('layui-hide');
                        $('[name="menu_icon"]').val('');
                    }else{
                        $('[name="menu_icon"]').parent().parent('.layui-form-item').removeClass('layui-hide');
                    }
                }
                if(data.value == 'B' || data.value == 'G'){
                    $('[name="log_rule"]').parent().parent('.layui-form-item').removeClass('layui-hide');
                }else{
                    $('[name="log_rule"]').parent().parent('.layui-form-item').addClass('layui-hide');
                    $('[name="log_rule"]').val('');
                }
            });

            //监听按钮事件
            form.on('select(btn_event)', function(data){
                //非自定义事件
                if(data.value!='custom'){
                    $('[name="btn_func"]').val(data.value);
                    $('[name="btn_func"]').addClass('layui-disabled');
                    if(data.value=='add'||data.value=='edit'||data.value=='show'){
                        renderColorpicker('#009688');//默认墨绿色
                        $('[name="btn_css"]').val('');
                    }
                    if(data.value=='del' || data.value == 'delBatch'){
                        renderColorpicker('#FF5722');
                        $('[name="btn_css"]').val('#FF5722');
                    }

                }else{
                    $('[name="btn_func"]').val('');
                    $('[name="btn_func"]').removeClass('layui-disabled');
                }

            });



            function renderColorpicker(dColor){
                colorpicker.render({
                    elem: '#buttonCss'
                    ,color: dColor //设置默认色
                    ,predefine: true // 开启预定义颜色
                    ,done: function(color){
                        $('[name="btn_css"]').val(color);
                    }
                });
            }
        });


    </script>

{/block}
