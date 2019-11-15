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

class Usercommon extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,UserModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,微信头像,微信昵称,用户姓名,手机号码,用户状态,个人销售总额,个人系列酒销售总额,最近登录时间,创建时间');
            $this->pageUtil->setColsWidthArr([1=>100,4=>120,5=>100,6=>140,7=>180,8=>160,9=>160,10=>180]);
            $this->pageUtil->setColsMinWidthArr([2=>150,3=>100]);
            $this->pageUtil->setColTemplet(5,"#statusTpl");
            $this->pageUtil->setColTemplet(1,"#imgTpl");
        }else{
            $where  = getWhereParam(['id','name'=>'like','phone'=>'like','status','create_time'=>['create_start','create_end']],$this->post);
            $where[] = ['level','=',0];
            $pageData = $this->model::field('id,headimgurl,nickname,name,phone,status,total_sale_user,xl_sale_user,last_login_time,create_time')
                ->where($where)
                ->order('status asc,create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }
}