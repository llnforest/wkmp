<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\UserModel;
use common\profit\Profit;
use Firebase\JWT\JWT;
use think\App;
use think\facade\Config;

class Api extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    //授权登陆
    public function getToken(){
        $param = $this->param;
        if(empty($param['code'])) return json(errRes([],'请传入参数code'));
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.Config::get('app.wechat.appid').'&secret='.Config::get('app.wechat.appsecret').'&js_code='.$param['code'].'&grant_type=authorization_code';
//        $info = file_get_contents($url);//发送HTTPs请求并获取返回的数据，推荐使用curl
        $info = $this->http_post($url);
        $json = json_decode($info,true);//对json数据解码
        if(empty($json['openid']))  return json(errRes([],'参数code错误'));
        $user = UserModel::get(['openid'=>$json['openid']]);
        if(empty($user)){
            UserModel::create(['openid'=>$json['openid']]);
        }
        $this->data['user'] = $user;


        $tokenInfo = [
            "iss"=>"",  //签发者 可以为空
            "aud"=>"", //面象的用户，可以为空
            "iat" => time(), //签发时间
            "nbf" => time(), //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => time()+Config::get('app.token.expire'), //token 过期时间
            "user_id" => $user['id'] //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
        ];


        $this->data['user']['token'] = JWT::encode($tokenInfo,Config::get('app.token.key'),'HS256');

        return json(operateResult($this->data['user'],'授权登陆'));
    }

    /**
     * 每日更新用户等级接口
     */
    public function updateUserLevel(){
        Profit::updateLevelEveryDay();
    }

    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    private function http_post($url, $param = [], $header = '', $post_file=false)
    {
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (PHP_VERSION_ID >= 50500 && class_exists('\CURLFile')) {
            $is_curlFile = true;
        } else {
            $is_curlFile = false;
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true );
        if($header){
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($oCurl, CURLOPT_POST,true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode($param));
//        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

}

