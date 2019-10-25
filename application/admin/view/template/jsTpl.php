<script>
    //弹框iframe的公用对象
    function getOpenObj(obj,refresh){
        var openObj = {
            title:obj.menu_name,
            type: 2,
            closeBtn:1,
            area: ['800px', '500px'],
            offset: 't',
            fixed: false, //不固定
            maxmin: false,
            scrollbar:false,
            moveOut :true,
            anim: 5, //0-6的动画形式，-1不开启
            shade: 0,
            content: '__ADMINPATH__'+obj.menu_url
        }
        if(refresh){
            var extendObj = {
                end:function(){
                    if(window.tools.refresh){
                        initFunc(true);
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    initFunc(false,"网络异常!");
                }
            }
            $.extend(true,openObj,extendObj);
        }
        return openObj;
    }

    //发送ajax请求
    function sendAjax(obj,data,refresh,fail){
        $.ajax({
            url: '__ADMINPATH__'+obj.menu_url,
            type:"POST",
            data:data,
            dataType:'json',
            beforeSend:function(){
                layer.load(2,{offset:offsetTop});
            },
            complete:function(){
                layer.closeAll('loading');
            },
            success: function(d){
                if(d.code == '0'){
                    layer.msg(obj.menu_name+"成功",{offset:offsetTop});
                    initFunc(refresh);
                }else{
                    layer.msg(d.msg,{offset:offsetTop});
                    initFunc(fail);
                }
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                initFunc(false,"网络异常!");
            }
        });
    }

    /**
     * 公用打开弹框方法
     * @param obj 对象
     * @param refresh 刷新 false不刷新 ture刷新
     */
    function commonOpen(obj,refresh){
        refresh = refresh == false ? false : true;
        layui.use('layer', function(){
            layer.open(getOpenObj(obj,refresh));
        });
    }

    /**
     * 公用异步方法
     * @param obj 对象
     * @param data 数据
     * @param refresh 刷新 false不刷新 true刷新 成功后是否刷新 默认true
     * @param fail 刷新 false不刷新 true刷新 失败后是否刷新 默认false
     * @param cancel 刷新 取消操作关闭弹框后是否刷新 默认false;
     */
    function commonAjax(obj,data,refresh,fail,cancel){
        refresh = refresh == false ? false: true;
        fail = fail || false;
        if(obj.confirm == false){
            sendAjax(obj,data,refresh,fail);
        }else{
            var index = layer.confirm('确认'+(obj.msg == false?'':'该条记录')+'要 '+obj.menu_name+' 吗？',{offset: offsetTop}, function(index){
                sendAjax(obj,data,refresh,fail);
            },function(){
                cancel = cancel || false;
                initFunc(cancel);
            });
        }
    }

    //通用表单提交
    function commonSubmit(data){
        $.ajax({
            url:'__ADMINPATH__'+data.extend.url,
            type:'POST',
            dataType:'json',
            data: data.field,//表单数据
            beforeSend:function(){
                layer.load(2,{offset:offsetTop});
            },
            complete:function(){
                layer.closeAll('loading');
            },
            success:function(d){
                if(d.code=='0'){
                    layer.msg(data.extend.name+'成功！',{time:500,offset:offsetTop},function(){
                        console.log(data);
                        if(data.extend.jump == "true"){
                            //window.parent.location.reload();
                            layer.close(data.extend.index);
                        }
                        window.tools.refresh = true;//设置页面刷新
                    });
                }else{
                    //提交出错，记录错误日志
                    layer.msg(d.msg,{offset:offsetTop});
                }
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                layer.msg("网络异常",{offset:offsetTop});
            }
        });
    }

    //通用的新增方法
    function add(obj){
        commonOpen(obj);
    }

    //通用的修改方法
    function edit(obj){
        obj.menu_url += '/id/'+obj.data.col0;
        commonOpen(obj);
    }

    //通用的查看方法，如日志
    function show(obj){
        obj.menu_url += '/readonly/true/id/'+obj.data.col0;
        commonOpen(obj,false);
    }

    //通用的删除方法
    function del(obj){
        commonAjax(obj,{id:obj.data.col0});
    }

    //通用的修改排序（第一列）
    function col1(obj){
        obj.menu_url = "{:str_replace('index','edit',$auth.url)}";
        obj.menu_name = '修改排序';
        obj.confirm = false;
        commonAjax(obj,{id:obj.data.col0,sort:obj.value},false,true)
    }

    //通用批量删除方法
    function delBatch(obj){
        if(checkIds.length == 0){
            layer.msg("您还没有勾选纪录哦！",{offset:offsetTop});
            return;
        }
        commonAjax(obj,{ids:checkIds});
    }

    function onRadio(obj){
        return obj;
    }

    function onCheck(data){
        checkIds = [];
        for(var i=0;i<data.length;i++){
            checkIds.push(data[i].col0);
        }
    }

    function clickNode(obj){

    }

    //初始化函数
    //refresh 刷新是否重置
    //msg     是否有弹框
    function initFunc(refresh,msg){
        var refresh = refresh || false;
        if(refresh){
            window.tools.refresh = false;
            checkIds = [];
            radioData = {};
            table.reload('listTable',{where:whereField});
        }
        msg ? layer.msg(msg,{offset:offsetTop}) : '';
    }
</script>