<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;



use app\index\model\UserModel;
use common\sms\SendMsg;
use think\App;
use think\facade\Cache;
use think\facade\Config;
use think\Validate;

class Sms extends AuthController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * 发送验证码
     * @return \think\response\Json
     */
    public function sendCode(){
        $roleValidate = ['phone|手机号码' => 'require|mobile','num|参数' => 'require','secret|参数' => 'require'];
        $validate = new Validate($roleValidate);
        if(!$validate->check($this->param))  return errRes('',$validate->getError());
        $phone = $this->param['phone'];
        $userInfo = UserModel::get($this->user_id);
        if($userInfo['phone'] == $phone) return json(errRes([],'手机号码未修改'));
        //判断发送的时间间隔
        $valCache = Cache::get(Config::get('app.sms.sms_pre').$phone);
        $time = isset($valCache['time'])?$valCache['time']:0;
        if(time()-$time <= Config::get('app.sms.sms_code_time')) return errRes('',lang('sms_phone_time_error'));
        //判断当日发送量
        $numCache = Cache::get(Config::get('app.sms.sms_code_pre').$phone);
        $day = isset($numCache['day'])?$numCache['day']:'';
        $count = isset($numCache['count'])?$numCache['count']:0;
        $num = isset($numCache['num'])?$numCache['num']:[];
        //判断随机数是否使用
        if(in_array($this->param['num'],$num)) return errRes('',lang('sms_phone_send_again'));
        //判断加密是否正确
        if(md5($phone.Config::get('app.sms.sms_code_random').$this->param['num']) != $this->param['secret']) return errRes('',lang('sms_phone_send_again'));
        $num[] = $this->param['num'];
        if($day == date('Y-m-d',time())){
            if($count >= Config::get('app.sms.sms_code_count')) return errRes('',lang('sms_phone_num_error'));

        }

        $code = rand(100000,999999);
        //获取短信模板，发送短信
        $content = SendMsg::getTemplate(1,['[0]' => $code]);
        $result = SendMsg::send($phone,$content);
        if($result){
            Cache::set(Config::get('app.sms.sms_code_pre').$phone,['day '=> date('Y-m-d',time()),'count' => $count + 1,'num' => $num],3600*24);
            Cache::set(Config::get('app.sms.sms_pre').$phone,['sms'=>$code,'time'=>time()],1800);
        }
        return json(operateResult($result,'短信发送'));

    }

    //删除已用短信验证码
    public static function removeSms($phone){
        Cache::rm(Config::get('app.sms.sms_pre').$phone);
    }

    //静态验证短信验证码
    public static function checkSms($phone,$usms){
        if(empty($phone)) return errRes('',lang('sms_check_phone_error'));
        if(empty($usms)) return errRes('',lang('sms_data_error'));
        $valCache = Cache::get(Config::get('app.sms.sms_pre').$phone);
        $sms = isset($valCache['sms'])?$valCache['sms']:'';
        if($usms != $sms)return errRes('',lang('sms_data_error'));
        Cache::rm(Config::get('app.sms.sms_pre').$phone);
        return sucRes('',lang('sms_check_success'));
    }




}

