<?php
/**
 * User: Lynn
 * Date: 2020/7/3
 * Time: 9:24
 */

namespace app\index\controller;



use think\App;
use think\Controller;

class Demo extends Controller {
    public static $now;
    public static $start_id = 4859;
    public static $sell_id = 3;
    public static $phone_name = [];
    public static $brand_id;
    public static $is_check = 0;
    public static $phoneList;
    public static $levelList;
    public static $temp_name;
    public static $add_num = 0;
    public static $token;
    public static $documentNo;
    public static $pageSize = 200;
    public static $checkIosReport = [];
    public static $checkAndReport = [];
    public static $checkPhoneName = [];
    public static $checkPhoneModel = [];
    public static $checkLevel = [];
    public static $checkChannelIOS = [];
    public static $checkChannelAnd = [];
    public static $errMsg = '';

    function __construct(App $app = null)
    {
        parent::__construct($app);
    }


    //获取token type 1拉数据 2上传数据
    public function getToken($type){
        $url = 'https://sjapi.aihuishou.com/sj-api/auth/login?timestamp='.time();
//        ['userName' =>'13135556886','passWord' => 'gaowei123'];
        if($type == 1) $param = ['userName' =>'17682300512','passWord' => 'gaowei123'];
        elseif($type == 2) $param = ['userName' =>'13023055915','passWord' => 'gaowei123'];
        elseif($type == 3) $param = ['userName' =>'18715129491','passWord' => 'gaowei123'];
        elseif($type == 4) $param = ['userName' =>'18654169025','passWord' => 'gaowei123'];
        elseif($type == 5) $param = ['userName' =>'18715022767','passWord' => 'gaowei123'];
        elseif($type == 6) $param = ['userName' =>'18860439141','passWord' => 'gaowei123'];
        elseif($type == 7) $param = ['userName' =>'13067982019','passWord' => 'gaowei123'];
        else $param = ['userName' =>'15256950064','passWord' => 'zjb99999'];

        $param = ['userName' =>'13067982019','passWord' => 'gaowei123'];
        $header = ['Accept:application/json,text/plain, */*','Accept-Encoding:gzip, deflate, br','Accept-Language:zh-CN,zh;q=0.8','Content-Type:application/json;charset=UTF-8','Platform:web','Connection:keep-alive','app:PJT','Host:sjapi.aihuishou.com','Origin:https://pai.aihuishou.com','Referer:https://sj.aihuishou.com/dist/index.html','User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.104 Safari/537.36'];
//        $result = json_decode($this->http_post($url, $param, $header),true);
        $result = $this->httpRequest($url, 'POST',json_encode($param,JSON_UNESCAPED_UNICODE), $header);
        var_dump($result);
        if($result['code'] != 200) die('登录失败！'.$result['resultMessage']);
        self::$token = $result['data']['accessToken'];
    }


    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    private function http_post($url, $param, $header, $post_file=false)
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
        var_dump($sContent);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

    function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false)
    {
        $method = strtoupper($method);
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 0); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
        curl_setopt($ci, CURLOPT_TIMEOUT, 0); /* 设置cURL允许执行的最长秒数 */
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        switch ($method) {
            case "POST":
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
                }
                break;
            case "PUT":
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                }
                break;
            default:
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
                break;
        }
        $ssl = preg_match('/^https:\/\//i', $url) ? true : false;
        curl_setopt($ci, CURLOPT_URL, $url);
        if ($ssl) {
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
            curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false); // 不从证书中检查SSL加密算法是否存在
        }
        //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ci, CURLOPT_MAXREDIRS, 2); /*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);

        /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
        $response = curl_exec($ci);
        $requestinfo = curl_getinfo($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        if ($debug) {
            echo "===== data======\r\n";
            var_dump($postfields);
            echo "=====info===== \r\n";
            print_r($requestinfo);
            echo "=====response=====\r\n";
            print_r($response);
        }
        curl_close($ci);
//    var_dump($response);
        return json_decode(trim($response,chr(239).chr(187).chr(191)),true);;
        //return array($http_code, $response,$requestinfo);
    }
}