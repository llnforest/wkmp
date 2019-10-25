<html>
<head>
    <title>登录——__ADMINAPP__</title>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="__ADMINSTATIC__/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="__ADMINSTATIC__/css/app/login.css" media="all">
</head>
<div id="app"></div>
<div class="m-login">
    <div class="login-head"><img class="logo" src="__PublicAdmin__/images/logo.png" >__ADMINAPP__</div>
    <form  class="layui-form" id="_form" onsubmit="return false">
            <div class="layui-form-item field-loginform-username required">
                <input type="text" class="layui-input" name="name"  id="login-name" maxlength="256" placeholder="用户名" value="">
            </div>
            <div class="layui-form-item field-loginform-password required">
                <input type="password" id="login-password" class="layui-input" name="password" maxlength="256" placeholder="密码">
            </div>

            <div class="layui-form-item">
                <button type="submit" id="login" class="layui-btn layui-btn-fluid u-login-btn">登录</button>
            </div>
    </form>
<!--    <div class="power"></div>-->
</div>

<script src="__ADMINSTATIC__/layui/layui.js"></script>
<script src="__ADMINSTATIC__/js/login/login_canvas_1.js?{$Think.config.version_time}"></script>
<script src="__ADMINSTATIC__/js/login/login_canvas_2.js?{$Think.config.version_time}"></script>
<script>
    layui.use(['layer','jquery'], function(){
        var layer = layui.layer;
        var $ = layui.jquery;
        $('#login').click(function(){
            $.ajax({
                url:"{:url('index/login')}",
                data:$('#_form').serialize(),
                type:'post',
                success:function(res) {
                    if(res.code == 0) {
                        layer.msg('登录成功 正在跳转中...',{offset: '200px',anim: 1});
                        setTimeout(function() {
                            location.href = "{:url('index/admin')}";
                        }, 1000);
                    }else{
                        layer.msg('用户名或密码错误',{offset: '200px',anim: 1});
                    }
                },
                error : function(){
                      layer.closeAll();
                      layer.msg('系统异常！请联系管理员！',{offset: '200px',anim: 1});
                }
            })
        })
    })
</script>
