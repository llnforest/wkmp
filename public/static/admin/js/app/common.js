/** 判断传入对象是否为空 **/
function isEmpty(obj){
    if(typeof obj == "undefined" || obj == null || obj == "" || obj == "null" || obj == "NULL"){
        return true;
    }else{
        return false;
    }
}

//渲染日历方法
function renderDatePicker(){
    if($(".date-time").length > 0){
        //时间日期渲染
        layui.use('laydate', function(){
            var laydate = layui.laydate;
            $(".date-time").each(function(){
                var format = $(this).attr("dom-format") || 'yyyy-MM-dd';
                var type = $(this).attr("dom-type") || 'date';
                laydate.render({
                    elem:this,
                    format:format,
                    type:type
                })
            })
        });
    }
}