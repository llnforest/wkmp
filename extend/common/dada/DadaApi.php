<?php
/**
 * User: Lynn
 * Date: 2020/3/13
 * Time: 15:03
 */
namespace common\dada;


use common\dada\api\BaseApi;
use common\dada\config\Config;
use common\dada\client\DadaRequestClient;
use common\dada\config\UrlConfig;
use common\dada\model\OrderModel;

class DadaApi
{
    /**
     * 查询订单价格
     */
    public static function queryDeliverFee(){
        //*********************1.配置项*************************
        $config = new Config(true);

        //*********************2.实例化一个model*************************
        $model = new OrderModel();
        $model->setShopNo('wukong001');	// 第三方门店编号
        $model->setOriginId('2017051628647459');			// 第三方订单号
        $model->setCityCode('0551');						// 城市code(可以参照城市code接口)
        $model->setCargoPrice(1000);
        $model->setIsPrepay(0);
        $model->setReceiverName('测试');
        $model->setReceiverAddress('合肥市蜀山区之心城');
        $model->setReceiverPhone('13585849321');
        $model->setCallback(\think\facade\Config::get('app.wechat.dada_callback_url'));// 回调url, 每次订单状态变更会通知该url(参照回调接口)

        $url = UrlConfig::QUERY_DELIVER_FEE;
        //*********************3.实例化一个api*************************
        $api = new BaseApi($url,json_encode($model));
        //***********************4.实例化客户端请求************************
        $dada_client = new DadaRequestClient($config, $api);
        $resp = $dada_client->makeRequest();
        var_dump($resp);
        return $resp;
    }

    /**
     * 查询订单价格后发单
     */
    public static function addAfterQuery($deliverNo){
        //*********************1.配置项*************************
        $config = new Config(true);

        //*********************2.实例化一个model*************************
        $model = new \stdClass();
        $model->deliveryNo = $deliverNo;
        $url = UrlConfig::ADD_AFTER_QUERY;
        //*********************3.实例化一个api*************************
        $api = new BaseApi($url,json_encode($model));
        //***********************4.实例化客户端请求************************
        $dada_client = new DadaRequestClient($config, $api);
        $resp = $dada_client->makeRequest();
        var_dump($resp);
        return $resp;
    }



    /**
     * 获取城市code列表
     */
    public static function getCityCode(){
        //*********************1.配置项*************************
        $config = new Config(true);

        //*********************2.实例化一个model*************************
        // city_code 业务参数为""
        $model = "";
        $url = UrlConfig::CITY_CODE_URL;
        //*********************3.实例化一个api*************************
        $api = new BaseApi($url,$model);

        //***********************4.实例化客户端请求************************
        $dada_client = new DadaRequestClient($config, $api);
        $resp = $dada_client->makeRequest();
        var_dump($resp);
        //合肥：0551
    }


}