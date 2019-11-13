<?php
/**
 * 菜单管理控制器
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 10:38
 */

namespace app\admin\controller;


use app\admin\model\WineImgsModel;
use app\admin\model\WineModel;
use think\App;

class Wine extends BaseController
{
    function __construct(App $app = null)
    {
        parent::__construct($app,WineModel::class);
    }

    //分页渲染处理
    protected function renderPage(){
        if($this->request->isGet()){
            $this->page->setHeader('ID,排序,上下架,首页推荐,酒品名称,酒品封面,品牌名称,酒品系列,酒品分类,包装规格,市场价,会员价,添加时间,最后操作时间');
            $this->pageUtil->setColEdit(1);
            $this->pageUtil->setColsWidthArr([1=>70,2=>100,3=>100,5=>100,6=>150,7=>100,8=>100,9=>150,10=>100,11=>100,12=>180,13=>180,14=>250]);
            $this->pageUtil->setColsMinWidthArr([4=>280]);
            $this->pageUtil->setColTemplet(5,"#imgTpl");
            $this->pageUtil->setColTemplet(2,"#statusTpl2");
        }else{
            $this->pageUtil->setDataDictArr([3=>'isTrue',7=>'wineStyle',8=>'wineCate',9=>'wineSize']);
            $where  = getWhereParam(['wine_name'=>'like','brand_id','a.status','is_recommend','wine_style','wine_cate','wine_size'],$this->param);
            $pageData = $this->model::alias('a')
                ->join('pin_wine_brand b','a.brand_id = b.id','left')
                ->field('a.id,a.sort,a.status,is_recommend,wine_name,a.img,b.brand_name,wine_style,wine_cate,wine_size,mall_price,vip_price,a.create_time,a.update_time')
                ->where($where)
                ->order('status desc,sort asc,create_time desc')
                ->paginate($this->param['limit']?:"");
            $this->page->setData($pageData);
        }

    }

    /**
     * 修改产品图接口和页面
     */
    public function editjpt(){
        if($this->request->isPost()){
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            WineImgsModel::where(['wine_id'=>$this->id])->delete();
            $imgList = json_decode($this->param['img_data'],true);
            if(count($imgList) > 0){
                foreach($imgList as &$item){
                    $item['wine_id'] = $this->id;
                    $item['type'] = 1;//酒品图
                }
                $imgModel = new WineImgsModel();
                $imgModel->saveAll($imgList);
            }
            return operateResult(true,'edit');
        }else{
            isset($this->param['id']) && $this->data['info'] = $this->model::get($this->id);
            $this->data['imgList'] = WineImgsModel::where(['type'=>1])->order('sort asc,id asc')->select();
            return view('detailjpt',$this->data);
        }
    }

    /**
     * 修改详情图接口和页面
     */
    public function editxqt(){

        if($this->request->isPost()){
            if(!isset($this->param['id']) || empty($info = $this->model::get($this->id))) return paramRes();
            WineImgsModel::where(['wine_id'=>$this->id])->delete();
            $imgList = json_decode($this->param['img_data'],true);
            if(count($imgList) > 0){
                foreach($imgList as &$item){
                    $item['wine_id'] = $this->id;
                    $item['type'] = 2;//酒品图
                }
                $imgModel = new WineImgsModel();
                $imgModel->saveAll($imgList);
            }
            return operateResult(true,'edit');
        }else{
            isset($this->param['id']) && $this->data['info'] = $this->model::get($this->id);
            $this->data['imgList'] = WineImgsModel::where(['type'=>2])->order('sort asc,id asc')->select();
            return view('detailxqt',$this->data);
        }
    }

}