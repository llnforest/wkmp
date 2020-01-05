<?php
/**
 * 雪豹云短信
 */
namespace common\sms;

use think\facade\Config;

class SendMsg{

    // 发送短信
    public static function send($mobile,$content){
        $post_data = array();
            $post_data['userid'] = Config::get('app.sms.user_id');
        $post_data['account'] = Config::get('app.sms.account');
        $post_data['password'] = Config::get('app.sms.password');
        $post_data['content'] = $content; //短信内容
        $post_data['mobile'] = $mobile;
        $post_data['sendtime'] = Config::get('sms.sendtime'); //时定时发送，输入格式YYYY-MM-DD HH:mm:ss的日期值
        $url='http://web.xbysp.com/sms.aspx?action=send';
        $o='';
        foreach ($post_data as $k=>$v)
        {
            $o.="$k=".urlencode($v).'&';
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //获取短信模板
    public static function  getTemplate($type,$data){
        $template = '';
        switch($type){
            //发送验证码
            case 1:
                $template = "【悟空名品】您好，您本次登录的验证码为[0]，如非本人操作，请忽略！30分钟内有效！";
                break;
            //发送下单付款通知
            case 2:
                $template = "【悟空名品】您有一个新的已付款订单，订单编号：[0]，请注意查看！";
                break;
            //发送下单付款通知
            case 3:
                $template = "【悟空名品】商城增加了一位新会员,订单编号：[0]，请注意查看！";
                break;
            default:
                break;

        }
        $content = strtr($template,$data);
        return $content;
    }


}