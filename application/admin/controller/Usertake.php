<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\UserModel;
use app\admin\model\UserTakeModel;
use think\App;

class Usertake extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,UserTakeModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            if(isset($this->param['user_id'])){
                $userInfo = UserModel::get($this->param['user_id']);
                $this->data['name'] = $userInfo->name;
                $this->data['phone'] = $userInfo->phone;
            }
            $this->page->setHeader('ID,会员姓名,手机号码,会员等级,提现金额,手续费用,提现状态,备注说明,提现时间');
            $this->pageUtil->setColsWidthArr([1=>120,2=>120,3=>100,4=>100,5=>100,6=>100,8=>160]);
            $this->pageUtil->setColsMinWidthArr([7=>300]);
            $this->pageUtil->setToolBar(false);

        }else{
            $this->pageUtil->setDataDictArr([3=>'userLevel',6=>'takeStatus']);
            $where  = getWhereParam(['b.name'=>'like','b.phone'=>'like','a.status','a.create_time'=>['create_start','create_end']],$this->post);
            $pageData = $this->model::alias('a')
                ->join('pin_user b','a.user_id = b.id','left')
                ->field('a.id,b.name,b.phone,b.level,a.money,a.handle_fee,a.status,a.remark,a.create_time')
                ->where($where)
                ->order('a.create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }
}