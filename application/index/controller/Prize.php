<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\SiteBannerModel;
use app\index\model\SiteInfoModel;
use app\index\model\SiteSearchHotModel;
use app\index\model\SysDictModel;
use app\index\model\SysDictValueModel;
use app\index\model\UserCartModel;
use app\index\model\UserSerachModel;
use app\index\model\WineBrandModel;
use app\index\model\WineImgsModel;
use app\index\model\WineModel;
use think\App;
use think\facade\Config;

class Prize extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }


    /**
     * 酒品搜索列表
     * @return \think\response\Json
     */
    public function gift(){
        $this->data['giftList'] = SysDictModel::alias('a')
                                ->join('sys_dict_value b','a.id = b.dict_id','left')
                                ->where(['a.dict_code' => 'giftType'])
                                ->field('b.*')
                                ->order('b.sort asc')
                                ->select();
        foreach($this->data['giftList'] as &$v){
            $v['remark'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['remark']);
        }
        return json(sucRes($this->data));
    }



    //---------------------------------操作API---------------------------------


}

