<?php
/**
 * User: Lynn
 * Date: 2019/11/18
 * Time: 11:55
 */

namespace app\index\controller;


use app\index\model\WineBrandModel;
use app\index\model\WineModel;
use common\dict\DictUtil;
use think\App;
use think\facade\Config;

class Cate extends BaseController
{
    protected $data;
    function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * 获取分类列表
     * @return \think\response\Json
     */
    public function getCateList(){
        $this->data['cateList'] = DictUtil::getDictValue('wineCate');
        return json(sucRes($this->data));
    }

    /**
     * 酒品分类列表
     * @return \think\response\Json
     */
    public function searchList(){
        $where[] = ['cate_id','=',$this->param['cate_id']];
        $where[] = ['status','=',1];
        if(!empty($this->param['keywords'])) $where[] = ['wine_name','like','%'.$this->param['wine_name'].'%'];
        if(!empty($this->param['min'])) $where[] = ['mall_price','>=',$this->param['min']];
        if(!empty($this->param['max'])) $where[] = ['mall_price','<',$this->param['max']];
//        $page = !empty($this->param['page'])?$this->param['page']:1;
        $this->data['brandList'] = WineBrandModel::where(['status' => 1])->order('sort asc')->select();
        $wineList = WineModel::where($where)->order('sort asc')->select();
        $subList = [];
        foreach($wineList as $v){
            $v['img'] = Config::get('app.upload.img_url').str_replace('\\','/',$v['img']);
            $subList[$v['brand_id']][] = $v;
        }
        foreach($this->data['brandList'] as $k => &$v){
            if(!isset($subList[$v['id']])){
                unset($this->data['brandList'][$k]);
                continue;
            }
            $v['sublist'] = $subList[$v['id']];
        }

        return json(sucRes($this->data));
    }

}

