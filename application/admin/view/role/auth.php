{layout name="template/detailTpl" /}

{extend name="template/detailTpl" /}
{block name="formBody"}
<input type="hidden" name="new_menus" value="" class="newMenus"/>
<div class="role-menu-main">
    <div >
        <label class="layui-form-label">角色名称</label>
        <div class="layui-input-block">

            <label class="layui-form-label" style="text-align: left;">{$info.name}</label>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-form-item">
            <label class="layui-form-label">选择权限</label>
            <div class="layui-input-block">
                <div id="LAY-auth-tree-index"></div>
            </div>
        </div>
    </div>
</div>

{/block}

{block name="jsBody"}
<script>
    layui.config({
        base: '__ADMINSTATIC__/layui_ext/authTree/',
    }).extend({
        authtree: 'authtree',
    });
    layui.use(['jquery', 'authtree', 'form', 'layer'], function(){
        var $ = layui.jquery;
        var authtree = layui.authtree;
        var form = layui.form;
        var layer = layui.layer;
        var menuList = [];

        $.ajax({
            url:"__ADMINPATH__admin/role/getAuth",
            type:'POST',
            data: {id:{$info.id}},//表单数据
            beforeSend:function(){
                layer.load(2);
            },
            complete:function(){
                layer.closeAll('loading');
            },
            success:function(data){
                if(data.code=='0'){
                    // 渲染时传入渲染目标ID，树形结构数据（具体结构看样例，checked表示默认选中），以及input表单的名字
                    authtree.render('#LAY-auth-tree-index', data.data, {
                        inputname: 'ids[]'
                        ,layfilter: 'lay-check-auth'
                        ,autowidth: true
                    });

                    // 使用 authtree.on() 不会有冒泡延迟
                    authtree.on('change(lay-check-auth)', function(data) {
                        console.log('监听 authtree 触发事件数据', data);
                        // 获取所有节点
                        var all = authtree.getAll('#LAY-auth-tree-index');
                        // 获取所有已选中节点
                        var checked = authtree.getChecked('#LAY-auth-tree-index');
                        // 获取所有未选中节点
                        var notchecked = authtree.getNotChecked('#LAY-auth-tree-index');
                        // 获取选中的叶子节点
                        var leaf = authtree.getLeaf('#LAY-auth-tree-index');
                        // 获取最新选中
                        var lastChecked = authtree.getLastChecked('#LAY-auth-tree-index');
                        // 获取最新取消
                        var lastNotChecked = authtree.getLastNotChecked('#LAY-auth-tree-index');
                        console.log(
                            'all', all,"\n",
                            'checked', checked,"\n",
                            'notchecked', notchecked,"\n",
                            'leaf', leaf,"\n",
                            'lastChecked', lastChecked,"\n",
                            'lastNotChecked', lastNotChecked,"\n"
                        );
                        $(".newMenus").val(checked.join(","))
                    });
                    updateNewMenus()


                    //更改复选框值
                    function updateNewMenus(){
                        menuList = [];
                        $(".authtree-checkitem").each(function(){
                            if($(this).prop("checked")){
                                menuList.push($(this).val());
                            }
                        })
                        console.log(menuList.length);
                        $(".newMenus").val(menuList.join(","));
                    }
                }else{
                    //提交出错，记录错误日志
                    layer.msg(d.desc,{offset:"180px"});
                }
            }
        });
    });

</script>
{/block}
