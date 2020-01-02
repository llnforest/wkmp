<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用调试模式
    'app_debug'              => true,

    //上传路径配置
    'upload'        =>[
        'path'      =>  '../public',
        'img_url'   => 'http://admin.99wukong.test'
    ],
    //短信配置
    'sms'                   => [
        'user_id'   => '97',
        'account'   => 'ynkj',
        'password'  => 'ynkj123',
        'send_time' => '',
        'sms_code_count'    => 10,
        'sms_code_time'   => 60,
        'sms_pre'   => 'sms_pre_',
        'sms_code_pre'   => 'sms_code_pre_',
        'sms_code_random'   => 'BVCXa1.4jdPPksMndkE3_oO0*',

    ],
];
