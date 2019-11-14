<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\UserModel;
use think\App;

class Uservip extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,UserModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,微信头像,微信昵称,会员姓名,手机号码,会员等级,会员状态,账户余额,总收益,个人销售总额,团队销售总额,个人系列酒销售总额,团队系列酒销售总额,团队总人数,vip团队数,推广团队数,高级团队数,入会时间,最近登录时间,创建时间');
            $this->pageUtil->setColsWidthArr([1=>100,4=>120,5=>100,6=>100,7=>100,8=>100,9=>140,10=>140,11=>180,12=>180,13=>120,14=>120,15=>120,16=>120,17=>160,18=>160,19=>160,20=>380]);
            $this->pageUtil->setColsMinWidthArr([2=>150,3=>100]);
            $this->pageUtil->setColTemplet(6,"#statusTpl");
            $this->pageUtil->setColTemplet(1,"#imgTpl");
        }else{
            $this->pageUtil->setDataDictArr([5=>'userLevel']);
            $where  = getWhereParam(['name'=>'like','phone'=>'like','status','level','create_time'=>['create_start','create_end'],'join_time'=>['join_start','join_end']],$this->param);
            $where[] = ['level','neq',0];
            $pageData = $this->model::field('id,headimgurl,nickname,name,phone,level,status,balance,total_profit,total_sale_user,total_sale_team,xl_sale_user,xl_sale_team,total_person_num,vip_team_num,tg_team_num,gj_team_num,join_time,last_login_time,create_time')
                ->where($where)
                ->order('status asc,create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }
}