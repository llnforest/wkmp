<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\SysDictModel;
use app\index\model\UserModel;
use app\index\model\UserProfitModel;
use app\index\model\UserTakeModel;
use common\dict\DictUtil;
use think\App;
use think\facade\Config;

class Prize extends AuthController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * 奖励中心（未使用）
     * @return \think\response\Json
     */
    public function prize(){
        $this->data['userInfo'] = UserModel::where('id',$this->user_id)->find();
        $this->data['userInfo']['user_type'] = DictUtil::getDictName('userType',$this->data['userInfo']['type']);
        return json(sucRes($this->data));
    }

    /**
     * 提现记录
     * @return \think\response\Json
     */
    public function takeList(){
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $this->data['takeList'] = UserTakeModel::where(['user_id' => $this->user_id])->page($page,Config::get('paginate.list_rows'))->select();
        foreach($this->data['takeList'] as &$v){
            $v['status_text'] = DictUtil::getDictName('takeStatus',$v['status']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 我的收益
     * @return \think\response\Json
     */
    public function profit(){
//        $this->data['userInfo'] = UserModel::where('id',$this->user_id)->find();
        $page = !empty($this->param['page'])?$this->param['page']:1;
        $this->data['profitList'] = UserProfitModel::alias('a')
            ->where(['a.user_id' => $this->user_id])
            ->join('pin_user b','a.child_id = b.id','left')
            ->join('pin_user c','a.from_id = c.id','left')
            ->field('a.*,b.headimgurl,b.level,b.name as team_name,b.phone as team_phone,c.name as from_name,c.phone as from_phone')
            ->page($page,Config::get('paginate.list_rows'))->select();
        foreach($this->data['profitList'] as &$v){
            $v['type_text'] = DictUtil::getDictName('profitType',$v['type']);
        }
        return json(sucRes($this->data));
    }

    /**
     * 我的团队
     * @return \think\response\Json
     */
    public function team(){
        $userInfo = UserModel::where('id',$this->user_id)->find();
        $where = ['parent_id' => $this->user_id];
        $where['level'] = isset($this->param['level']) ? $this->param['level'] : 1;
        $this->data['teamList'] = UserModel::where($where)->select()->toArray();
        if($userInfo['level'] == $where['level']){
            array_unshift($this->data['teamList'],$userInfo);
        }
        return json(sucRes($this->data));
    }

    /**
     * 礼包页面
     * @return \think\response\Json
     */
    public function gift(){
        $this->data['giftList'] = SysDictModel::alias('a')
                                ->join('sys_dict_value b','a.id = b.dict_id','left')
                                ->where(['a.dict_code' => 'giftType'])
                                ->field('b.*')
                                ->order('b.sort asc')
                                ->select();
        foreach($this->data['giftList'] as $k=>&$v){
            if($k == 0) $this->data['selected'] = $v['id'];
            $v['remark'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['remark']);
        }
        return json(sucRes($this->data));
    }



    //---------------------------------操作API---------------------------------
    /**
     * 立即开通
     * @return \think\response\Json
     */
    public function goBuy(){
        if(!$this->request->has('gift_id') || !$this->request->has('phone')) return json(errRes([],'参数错误'));
        $result = '';
        return json(operateResult($result,'del'));
    }

}

