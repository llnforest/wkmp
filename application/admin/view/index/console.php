<html>
<head>
    <title>控制面板</title>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="__ADMINSTATIC__/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="__ADMINSTATIC__/css/app/style.css" media="all">
</head>
<div id="console">
    <p class="console-item">您好，<span class="layui-tx-green">{$Think.session.userInfo.nickname}</span>！欢迎登录<span class="layui-tx-green">__ADMINAPP__</span>！本次登录时间为<span class="layui-tx-green"> {$now_login}</span></p>
    {if isset($last_login)}<p class="console-item">您最近一次登录系统的时间为<span class="layui-tx-green"> {$last_login}</span>{if !empty($last_logout)}，安全退出时间为<span class="layui-tx-green"> {$last_logout}</span>{/if}</p>{/if}
</div>



