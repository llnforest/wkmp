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
    'upload'        => [
        'path'      =>  '../public',
        'img_url'   => 'https://admin.99wukong.cn'
    ],
    //短信配置
    'sms'          => [
        'user_id'   => '530',
        'account'   => 'wkmp',
        'password'  => 'wkmp.147',
        'send_time' => '',
        'sms_code_count'    => 10,
        'sms_code_time'   => 60,
        'sms_pre'   => 'sms_pre_',
        'sms_code_pre'   => 'sms_code_pre_',
        'sms_code_random'   => 'BVCXa1.4jdPPksMndkE3_oO0*',

    ],
    //微信配置
    'wechat'        => [
        'appid'             => 'wx9e86511465aa9905',
        'appsecret'            => 'd709dac1f0b64e14199eb0efdee1d448',

        'mch_id'            => '1564870861',
        'key'               => '923ksdKdjskI9sksdjfsdjksK823Ojk1',

        'create_order_url'      => 'https://api.mch.weixin.qq.com/pay/unifiedorder',//统一下单url
        'notify_wine_url'        => 'http://api.99wukong.test/index/wxpay/payorderwinenotify',//商品支付通知
        'notify_gift_url'        => 'http://api.99wukong.test/index/wxpay/payordergiftnotify',//会员支付通知

        'dada_callback_url'      => 'http://admin.99wukong.test/index/test/dadacallback',//达达回调接口
    ],
    //token配置
    'token'        => [
        'expire'             => 7200,
        'key'                => 'Hkd90Kwkdmd-dkajdk+kdsj.KlsaadjoO0'
    ],
];
