<?php
/**
 * User: Lynn
 * Date: 2020/3/17
 * Time: 18:58
 */
namespace common\profit;

use model\OrderGiftModel;
use model\UserModel;
use model\UserProfitModel;

class Profit
{
    /**
     * 礼包支付后分佣
     * @param $order_id
     */
    public static function giftProfit($order_id){
        $orderInfo = OrderGiftModel::where(['id'=>$order_id,'status'=>1])->find();
        if(empty($orderInfo)) return errRes([],'订单号错误或订单状态错误');
        $firInfo = UserModel::where(['id' => $orderInfo['from_id'],'status' => 1])->find();
        $type = 1;
        if(!empty($firInfo)){
            if($firInfo['level'] == 1){//vip用户
                self::addMoney($firInfo['id'],200,$type,$orderInfo['user_id'],$orderInfo['user_id']);
                if($firInfo['parent_id'] != 0){
                    $secInfo = UserModel::where(['id' => $firInfo['parent_id'],'status' => 1])->find();
                    if(!empty($secInfo) && $secInfo['level'] == 2){//推广用户
                        self::addMoney($secInfo['id'],100,$type,$firInfo['id'],$orderInfo['user_id']);

                        if($firInfo['parent_id'] != 0){
                            $thrInfo = UserModel::where(['id' => $secInfo['parent_id'],'status' => 1])->find();
                            if(!empty($thrInfo) && $thrInfo['level'] == 3){//高级用户
                                self::addMoney($thrInfo['id'],50,$type,$secInfo['id'],$orderInfo['user_id']);
                            }
                        }

                    }elseif(!empty($secInfo) && $secInfo['level'] == 3){//高级用户
                        self::addMoney($secInfo['id'],150,$type,$firInfo['id'],$orderInfo['user_id']);
                    }
                }

            }elseif($firInfo['level'] == 2){//推广用户
                self::addMoney($firInfo['id'],300,$type,$orderInfo['user_id'],$orderInfo['user_id']);
                if($firInfo['parent_id'] != 0){
                    $secInfo = UserModel::where(['id' => $firInfo['parent_id'],'status' => 1])->find();
                    if(!empty($secInfo) && $secInfo['level'] == 3){//高级用户
                        self::addMoney($secInfo['id'],50,$type,$firInfo['id'],$orderInfo['user_id']);
                    }
                }
            }elseif($firInfo['level'] == 3){//高级用户
                self::addMoney($firInfo['id'],350,$type,$orderInfo['user_id'],$orderInfo['user_id']);
            }
        }else{
            return errRes([],'上级用户不存在或用户状态禁用');
        }
    }

    /**
     * 添加收益
     * @param $user_id int
     * @param $money int
     * @param $type int 奖励类型 1礼包奖励 2销售额奖励 3流通酒奖励
     * @param $child_id int 来源下级团队
     * @param $from_id int 来源的个人
     */
    private static function addMoney($user_id,$money,$type,$child_id,$from_id){
        //维护余额、总收益、收益纪录
        UserModel::where('id',$user_id)->setInc('balance',$money);
        UserModel::where('id',$user_id)->setInc('total_profit',$money);
        UserProfitModel::create(['user_id' => $user_id,'money' => $money,'child_id' => $child_id,'from_id' => $from_id,'type' => $type]);
        if($type == 1){
            //维护团队总人数
            UserModel::where('id',$user_id)->setInc('total_person_num',1);
            //维护vip人数
            UserModel::where('id',$user_id)->setInc('vip_team_num',1);

        }
    }

    /**
     * 是否可以升级
     * @param $user_id
     */
    private static function isCanUpdate($user_id){

    }

    /**
     * 订单结束后分佣
     * @param $order_id
     */
    public static function orderSuccessProfit($order_id){

    }
}