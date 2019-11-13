<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\SiteInfoModel;
use think\App;

class Siteinfo extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,SiteInfoModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,主标题,副标题,简介,主图,第一张图,第一张图主标题,第一张图副标题,第二张图,第二张图主标题,第二张图副标题,第三张图,第三张图主标题,第三张图副标题,客服头像,客服名称,客服电话,客服二维码,最后操作时间');
            $this->pageUtil->setColsWidthArr([1=>200,2=>200,3=>300,4=>100,5=>100,6=>130,7=>130,8=>100,9=>130,10=>130,11=>100,12=>130,13=>130,14=>100,15=>130,16=>130,17=>140,18=>180,19=>200]);
            $this->pageUtil->setColTemplet(4,"#imgTpl4");
            $this->pageUtil->setColTemplet(5,"#imgTpl5");
            $this->pageUtil->setColTemplet(8,"#imgTpl8");
            $this->pageUtil->setColTemplet(11,"#imgTpl11");
            $this->pageUtil->setColTemplet(14,"#imgTpl14");
            $this->pageUtil->setColTemplet(17,"#imgTpl17");
            $this->pageUtil->setShowNumbers(false);
        }else{
            $pageData = $this->model::field('id,title,sub_title,description,img,fir_img,fir_name,fir_name_eng,sec_img,sec_name,sec_name_eng,thr_img,thr_name,thr_name_eng,kf_head_img,kf_name,kf_phone,kf_qr_img,update_time')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }

    /**
     * 修改接口和页面
     */
    public function editkf(){
        return $this->edit('detailkf');
    }


}