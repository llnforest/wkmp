<?php
/**
 * Sysuser: Lynn
 * Date: 2019/4/4
 * Time: 17:43
 */

namespace common\page;


use common\dict\DictUtil;

class PageDataTrans
{
/**
	 * 将数据库查询出来的表头cols数据转换成前端ui适配的json格式
	 * 2018年3月12日
	 * @param page
	 * @param pageUtil 页面工具类
	 * author:wangzhen
	 */
	public static function transPageCols($page,$pageUtil){
//        $page = new Page();
//        $pageUtil = new PageUtil();
		//转换表头数据
		$cols = [];
		if($page->getHeader()){
			//设置排序号
			if($pageUtil->getShowNumbers()){
				$colsNum['type'] = 'numbers';
				if($pageUtil->getFixedNumbers()){
					$colsNum['fixed'] = 'left';
				}
				$cols[] = $colsNum;
			}
			//设置多选框
			if($pageUtil->getShowCheckbox()){
				$colsChecked['type'] = 'checkbox';
				if($pageUtil->getAllchecked()){
					$colsChecked['LAY_CHECKED'] = 'true';
				}
				if($pageUtil->getFixedCheckbox()){
					$colsChecked['fixed'] = 'left';
				}
				$cols[] = $colsChecked;
			}
			//设置单选
			if($pageUtil->getShowRadio()){
				$colsRadio['type'] = 'radio';
				if($pageUtil->getFixedRadioBox()) $colsRadio['fixed'] = 'left';
				$cols[] = $colsRadio;
			}
			for ($i =$pageUtil->getBegin(); $i < count($page->getHeader()); $i++) {
			    $sub = [];
				$sub['field'] = 'col'.$i;
				$sub['title'] = $page->getHeader()[$i];
				//设置单元格点击事件名

				if($pageUtil->getColsEventArr($i)){
					$sub['event'] = $pageUtil->getColsEventArr($i);
				}
				//设置cols宽度
				if($pageUtil->getColsWidthArr($i)){
					$sub['width'] = $pageUtil->getColsWidthArr($i);
				}
				//设置cols最小宽度
				if($pageUtil->getColsMinWidthArr($i)){
					$sub['minWidth'] = $pageUtil->getColsMinWidthArr($i);
				}
				//设置固定列
				if($pageUtil->getColsFixedArr($i)){
					$sub['fixed'] = $pageUtil->getColsFixedArr($i);
				}
				//设置排序
				if($pageUtil->getColsSort()){
					$sub['sort'] = true;
				}else{
					if($pageUtil->getSortCols() && in_array($i,$pageUtil->getSortCols())){
						$sub['sort'] = true;
					}
				}
				//设置是否隐藏
				if($pageUtil->getColsHideArr($i)){
					$sub['hide'] = true;
				}
				//设置是否拖拽列宽，默认是允许的
				if($pageUtil->getUnresize() && in_array($i,$pageUtil->getUnresize())){
					$sub['unresize'] = true;
				}
				//设置单元格编辑类型
				if($pageUtil->getColsEditArr($i)){
					$sub['edit'] = $pageUtil->getColsEditArr($i);
				}
				//设置单元格样式
				if($pageUtil->getColsStyleArr($i)){
					$sub['style'] = $pageUtil->getColsStyleArr($i);
				}
				//设置单元格排列方式
				if($pageUtil->getAlign()){
					$sub['align'] = $pageUtil->getAlign();
				}
				//设置单元格模板
				if($pageUtil->getColsTempletArr($i)){
					$sub['templet'] = $pageUtil->getColsTempletArr($i);
				}
				$cols[] = $sub;
			}
			//设置工具条
			if($pageUtil->getToolbar()){
				$tool = ['fixed'=>'right','title'=>'操作', 'align'=> $pageUtil->getAlign(),'toolbar'=>'#'.$pageUtil->getToolbarId()];
				if($pageUtil->getColsWidthArr(count($page->getHeader()))){
					$tool['width'] = $pageUtil->getColsWidthArr(count($page->getHeader()));
				}
                //设置cols最小宽度
                if($pageUtil->getColsMinWidthArr(count($page->getHeader()))){
                    $tool['minWidth'] = $pageUtil->getColsMinWidthArr(count($page->getHeader()));
                }
				$cols[] = $tool;
			}

		}

		//如果启用多级表头，则采用自定义的表头数据
		if($pageUtil->getIsMultistage()){
		    $cols[] = $pageUtil->getMultistageHeader();
		}

		$page->setHeaderJson(json_encode([$cols]));


		//数据表格方法渲染其余参数
		$options = '';

		if($pageUtil->getWidth() > 0){
			$options .= ',width:'.$pageUtil->getWidth();
		}
		if($pageUtil->getCellMinWidth()>0){
			$options .= ',cellMinWidth:'.$pageUtil->getCellMinWidth();
		}
		if($pageUtil->getHeight()){
			$options .= ',height:'.$pageUtil->getHeight();
		}
		if($pageUtil->getText()){
			$options .= ',text:'.$pageUtil->getText();
		}
		if($pageUtil->getInitSortAsc()){
			$options .= ',initSort:'.$pageUtil->getInitSortAsc();
		}
		if($pageUtil->getInitSortDesc()){
			$options .= ',initSort:'.$pageUtil->getInitSortDesc();
		}
		if($pageUtil->getTableId()){
			$options .= ',id:"'.$pageUtil->getTableId().'"';
		}
		if($pageUtil->getSkin()){
			$options .=  ',skin:'.$pageUtil->getSkin();
		}
		if($pageUtil->getSize()){
			$options .= ',size:'.$pageUtil->getSize();
		}
		if($pageUtil->getEven()){
			$options .= ',even:true';
		}
		if($pageUtil->getShowPage()){

			$options .= ",page:true";
		}
		if($pageUtil->getLimit() != 10){
		    $options .= ',limit:'.$pageUtil->getLimit();
        }

		$page->setOptions($options);
		$page->setShowQueryBut($pageUtil->getShowQueryBut());
		$page->setShowExportBut($pageUtil->getShowExportBut());
		return $page;
	}


	/**
	 * 将数据库查询出来的列表数据转换成前端ui适配的json格式
	 * 2018年3月12日
	 * @param page
	 * @param pageUtil 页面工具类
	 * author:Lynn
	 */
	public static function transData($page,$pageUtil){
//	    $page = new Page();
//	    $pageUtil = new PageUtil();
		$cols = ['code'=>lang('success_code'),'msg'=>'success','count'=>$page->getRowSize()];
		$data = $page->getData();
		if($data){
			for ($i = 0; $i < count($data); $i++) {
				$rowList = array_values($data[$i]->toArray());
				if($rowList){
					$sub = [];
					$col = 0;
					for ($k = 0; $k < count($rowList); $k++) {
						//获取每一列数据
						$td = $rowList[$k];

                        //判断是否映射编码
                        if($pageUtil->getDataDictArr($col)){
                            //获取编码对应的数据
                            $td = DictUtil::getDictNameColor($pageUtil->getDataDictArr($col), $td);
                        }
                        $sub['col'.$col] = $td;
						$col ++;

					}
					$cols['data'][] = $sub;
				}

			}
		}
		return $cols;
	}

}