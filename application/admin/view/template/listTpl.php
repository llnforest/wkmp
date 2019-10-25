<html>
<head>
    <title>{$title?:''}</title>
    {include file="template/headTpl"}
    {block name="headBody"}<!-- 头部引用区域 -->{/block}
</head>

<body>
    <div class="layui-row layui-col-space0" >
        <div class="layui-col-lg12" id="app">
            {if $listTabs != '[]'}
            <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" v-if="listTabs.length > 0" id="tabBody">
                <ul class="layui-tab-title">
                    <template v-for="tab in listTabs">
                        <li class="layui-this" v-on:click="tabEvent(tab.menu_url)" v-if="tab.menu_url == '{$auth.url}'">{{ tab.menu_name }}</li>
                        <li v-on:click="tabEvent(tab.menu_url)" v-else>{{ tab.menu_name }}</li>
                    </template>
                </ul>
            </div>
            {/if}
            <form class="layui-form" name="ListForm" method="POST" action="">
                <div class="layui-form-item plat-list-query">
                    {block name="queryBody"}<!-- 查询区域 -->{/block}
                    <div class="layui-form-item plat-list-query-button" id = "listBut">
                        <button v-show="{$page->isShowQueryBut()??'true'}" class="layui-btn layui-btn-sm" id="queryBut" type="button"  lay-submit  lay-filter="formQuery"><i class="layui-icon layui-icon-search"></i>查询</button>
                        <button v-show="{$page->isShowQueryBut()??'true'}" class="layui-btn layui-btn-sm" id="clearBut" type="reset"><i class="layui-icon layui-icon-file"></i>重置</button>
                        <button v-show="{$page->isShowExportBut()??'true'}" class="layui-btn layui-btn-sm" id="exportBut" type="button"><i class="layui-icon layui-icon-table"></i>导出</button>
                        <list-button v-for="but in listButs" :but="but" :key="but.id" v-on:event="butEvent(but)" />
                    </div>
                </div>
                <table class="layui-hide" id="listTable" lay-filter="listTableFilter"></table>

            </form>
        </div>
    </div>


    <script type="text/html" id="listBar"></script>
    <script type="text/html" id="listBarT">
        {{#  layui.each(d, function(index, item){ }}
        <a class="layui-btn layui-btn-xs" style="background-color:{{ item.btn_css }}" data-url="{{ item.menu_url }}" lay-event="{{ item.btn_func }}"> {{ item.menu_icon }}{{ item.menu_name }}</a>
        {{#  }); }}
    </script>


    <script>
        new Vue({
            el: '#app',
            data:{
                listButs:{$listButs|raw},
                listTabs:{$listTabs|raw}
            },
            methods: {
                butEvent: function (obj) {
                    var eventFunc = obj.btn_func;
                    console.log(eventFunc);
                    eval(eventFunc + "(obj);");
                },
                tabEvent:function(url){
                    console.log(url);
                    window.location.href = '__ADMINPATH__'+url;
                }
            }
        });

        var	checkIds = [];//复选框选中的ids
        var	whereField = {};//查询区域字段对象
        var radioData = {};//单选按钮值对象
        var offsetTop = ($(window).height()-154)/2 + 'px';;//定义弹框位置

        window.tools = {
            refresh : false //列表是否刷新
        }

        layui.use(['table','layer','form','laytpl','element'], function(){
            table = layui.table;
            var layer = layui.layer;
            var form = layui.form;
            var laytpl = layui.laytpl;
            var $ = layui.jquery;
            var title = '{$auth.name}';

            //生成一个操作工具条bar模板
            var getTpl = listBarT.innerHTML;
            laytpl(getTpl).render({$barButs|raw}, function(html){
                //将模板复制到空的模板listBar
                listBar.innerHTML=html;
                //如果需要自定义模板内容则需要更改pageUtil中bar对应的id值
            });

            //展示已知数据
            var tableIns = table.render({
                elem: '#listTable'
                ,method:'post'
                ,title:$.trim(title)
                ,cols: {$page->getHeaderJson()?:"[]"} //标题栏
                ,url:'{$Request.url}'
                {$page->getOptions()?:""}

            });


            //监听input框
            table.on('edit(listTableFilter)',function(obj){
                eval(obj.field+"(obj);")
            })

            //监听单击行事件
            table.on('radio(listTableFilter)', function(obj){
                eval("onRadio(obj);");//执行event函数
            });

            table.on('checkbox(listTableFilter)', function(obj){
                //console.log(obj.checked); //当前是否选中状态
                //console.log(obj.data); //选中行的相关数据
                //console.log(obj.type); //如果触发的是全选，则为：all，如果触发的是单选，则为：one
                var checkStatus = table.checkStatus('listTable');
                var data = checkStatus.data;
                //layer.alert(JSON.stringify(data));
                eval("onCheck(data);");//执行event函数
            });

            //监听工具条
            table.on('tool(listTableFilter)', function(obj){
                // var data = obj.data;//获取行数据
                var eventFunc = obj.event; //获得 lay-event 对应的值
                // var tr = obj.tr; //获得当前行 tr 的DOM对象
                obj.menu_url = $(this).attr("data-url");
                obj.menu_name = $(this).text();
                eval(eventFunc + "(obj);");//执行event函数
            });

            //回车搜索
            $('.plat-list-query input').bind('keydown', function (event) {
                var event = window.event || arguments.callee.caller.arguments[0];
                if (event.keyCode == 13){
                    $("#queryBut").click();
                }
            });

            //监听提交
            form.on('submit(formQuery)', function(data){
                checkIds = [];
                radioData = {};
                whereField = data.field
                tableIns.reload({
                    where: whereField
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
                return false;
            });

            //监听状态操作
            form.on('switch(dataFlag)', function(obj){
                obj.menu_url = "{:str_replace('index','edit',$switchDataUrl??$auth.url)}";
                obj.menu_name = '变更状态';
                console.log(obj);
                commonAjax(obj,{id:this.value,status:obj.elem.checked?1:0},false,true,true);
            });

        });

    </script>
    {include file="template/jsTpl"}
    {block name="jsBody"}<!-- 追加js -->{/block}
</body>
</html>
