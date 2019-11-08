<?php
/**
 * User: Lynn
 * Date: 2019/4/4
 * Time: 17:05
 */

namespace common\page;



class PageUtil
{


/**
 * 设定列宽（默认自动分配）。支持填写：数字、百分比。请结合实际情况，对不同列做不同设定
 * 如：200、30%
 */
    protected $colsWidthArr = [];
	/**
     * 局部定义当前常规单元格的最小宽度（默认：60），一般用于列宽自动分配的情况。其优先级高于基础参数中的 cellMinWidth
     */
    protected $colsMinWidthArr = [];
	/**
     * 固定列。可选值有：left（固定在左）、right（固定在右）。一旦设定，对应的列将会被固定在左或右，不随滚动条而滚动。
     * 如果是固定在左，该列必须放在表头最前面；如果是固定在右，该列必须放在表头最后面。
     */
    protected $colsFixedArr = [];
	/**
     * 控制列显示隐藏，默认为显示
     */
	protected $colsHideArr = [];
	/**
     * 设置列表是否显示序号
     */
	protected $showNumbers = true;
	/**
     * 设置是否将序号列设置为固定列
     */
	protected $fixedNumbers = false;
	/**
     * 设置列表是否显示多选框
     */
	protected $showCheckbox = false;
	/**
     * 设置列表是否显示单选
     */
	protected $showRadio = false;
	/**
     * 设置列表是否显示查询、重置按钮
     */
	protected $showQueryBut = true;
	/**
     * 设置列表是否显示查询、重置按钮
     */
	protected $showExportBut = true;
	/**
     * 设置是否将将多选框列设置为固定列
     */
	protected $fixedCheckbox = false;
	/**
     * 设置多选框初始状态是否全选，必须复选框列开启后才有效
     */
	protected $allchecked = false;
	/**
     * 设置单选框固定列
     */
	protected $fixedRadioBox = false;
	/**
     * 设置是否允许排序,字典序排列算法
     * 1.设置为true时即默认时全开
     * 2.设置成false时为全关
     * 3.在false状态下也可以指定个别列开启
     */
	protected $colsSort = true;



	/**
     * 当关闭colsSort排序参数时，可以指定个别列进行排序
     */
	protected $sortCols = [];
	/**
     * 数据列表默认是运行拖拽列宽的，该参数用于指定不能拖拽列宽的列
     */
	protected $unresize = [];

	/**
     * 单元格编辑类型（默认不开启）目前只支持：text（输入框）
     */
	protected $colsEditArr = [];

	/**
     * 自定义单元格点击事件名
     */
	protected $colsEventArr = [];
	/**
     * 自定义单元格样式。即传入 CSS 样式
     */
	protected $colsStyleArr = [];
	/**
     * 单元格排列方式。可选值有：left（默认）、center（居中）、right（居右）
     */
	protected $align = "left";

	/**
     * 启动多级复杂表头，当启用多级复杂表头时，需要自己主动传入表头内容
     */
	protected $isMultistage = false;
	/**
     * 多级表头内容，当启用多级复杂表头时，使用改字符串中数据作为列表表头
     */
	protected $multistageHeader;

	/**
     * 自定义列模板，模板遵循 laytpl语法
     * templet 提供了三种使用方式
     * 1.绑定模版选择器
     * 2.函数转义
     * 3.直接赋值模版字符
     */
	protected $colsTempletArr = [];

	/**
     * 设定容器宽度。table容器的默认宽度是跟随它的父元素铺满，你也可以设定一个固定值，当容器中的内容超出了该宽度时，会自动出现横向滚动条。
     */
	protected $width;

	/**
     * 设定容器高度
     * 1.默认情况。高度随数据列表而适应，表格容器不会出现纵向滚动条
     * 2.设定一个数字，用于定义容器高度，当容器中的内容超出了该高度时，会自动出现纵向滚动条 如：height: 315
     * 3.高度将始终铺满，无论浏览器尺寸如何。这是一个特定的语法格式，其中 full 是固定的，
     * 而 差值 则是一个数值，这需要你来预估，比如：表格容器距离浏览器顶部和底部的距离“和”  如：height: 'full-20'
     */
	protected $height;

	/**
     * 全局定义所有常规单元格的最小宽度（默认：60），一般用于列宽自动分配的情况。
     * 其优先级低于表头参数中的 minWidth
     */
	protected $cellMinWidth;

	/**
     * 自定义文本，如空数据时的异常提示等
     */
	protected $text;

	/**
     * 设置列表初始排序列-倒序排列
     */
	protected $initSortDesc;

	/**
     * 设置列表初始序列-正序配列
     */
	protected $initSortAsc;

	/**
     * 表格id
     */
	protected $tableId = "listTable";


	/**
     * 用于设定表格风格，若使用默认风格不设置该属性即可
     * line （行边框风格） row （列边框风格） nob （无边框风格）
     */
	protected $skin;

	/**
     * 用于设定表格尺寸，若使用默认尺寸不设置该属性即可
     * sm （小尺寸） lg （大尺寸）
     */
	protected $size;

	/**
     * 隔行换色，若不开启隔行背景，不设置该参数即可
     */
	protected $even = false;

	/**
     * 设置是否显示分页
     */
	protected $showPage = true;

	/**
     * 是否启用工具调列，工具条列默认的id为listBar
     */
	protected $toolbar = true;
	/**
     * toolbar默认id
     */
	protected $toolbarId = "listBar";
	/**
     * 设定list数据列表从第几列显示数据
     * 从0开始计数，通常情况下第0位是主键id
     * 所以该参数默认从第1位开始技术
     */
	protected $begin = 1;

	/**
     * 设定数据列表字典映射，如第3列映射为性别（1：男；0：女）
     * 则系统会将第三列数值中1转换为‘男’；0转换成‘女’
     */
	protected $dataDictArr = [];

	protected $limit;

	public function getLimit(){
	   return config('paginate.list_rows');
    }

    /**
     * @return mixed
     */
    public function getColsWidthArr($i)
    {
        if(isset($this->colsWidthArr[$i])) return $this->colsWidthArr[$i];
        else return false;
    }

    /**
     * @param mixed $colsWidthArr
     */
    public function setColsWidthArr($colsWidthArr)
    {
        $this->colsWidthArr = $colsWidthArr;
    }
    /**
     * @param mixed $colsWidthArr
     */
    public function setColWidth($index,$value)
    {
        $this->colsWidthArr[$index] = $value;
    }

    /**
     * @return mixed
     */
    public function getColsMinWidthArr($i)
    {
        if(isset($this->colsMinWidthArr[$i])) return $this->colsMinWidthArr[$i];
        else return false;
    }

    /**
     * @param mixed $colsMinWidthArr
     */
    public function setColsMinWidthArr($colsMinWidthArr)
    {
        $this->colsMinWidthArr = $colsMinWidthArr;
    }

    /**
     * @param mixed $colsWidthArr
     */
    public function setColMinWidth($index,$value)
    {
        $this->colsMinWidthArr[$index] = $value;
    }

    /**
     * @return mixed
     */
    public function getColsFixedArr($i)
    {
        if(isset($this->colsFixedArr[$i])) return $this->colsFixedArr[$i];
        else return false;
    }

    /**
     * @param mixed $colsFixedArr
     */
    public function setColsFixedArr($colsFixedArr)
    {
        $this->colsFixedArr = $colsFixedArr;
    }

    /**
     * @return mixed
     */
    public function getColsHideArr($i)
    {
        if(isset($this->colsHideArr[$i])) return $this->colsHideArr[$i];
        else return false;
    }

    /**
     * @param mixed $colsHideArr
     */
    public function setColsHideArr($colsHideArr)
    {
        $this->colsHideArr = $colsHideArr;
    }

    /**
     * @return mixed
     */
    public function getShowNumbers()
    {
        return $this->showNumbers;
    }

    /**
     * @param mixed $showNumbers
     */
    public function setShowNumbers($showNumbers)
    {
        $this->showNumbers = $showNumbers;
    }

    /**
     * @return mixed
     */
    public function getFixedNumbers()
    {
        return $this->fixedNumbers;
    }

    /**
     * @param mixed $fixedNumbers
     */
    public function setFixedNumbers($fixedNumbers)
    {
        $this->fixedNumbers = $fixedNumbers;
    }

    /**
     * @return mixed
     */
    public function getShowCheckbox()
    {
        return $this->showCheckbox;
    }

    /**
     * @param mixed $showCheckbox
     */
    public function setShowCheckbox($showCheckbox)
    {
        $this->showCheckbox = $showCheckbox;
    }

    /**
     * @return mixed
     */
    public function getShowRadio()
    {
        return $this->showRadio;
    }

    /**
     * @param mixed $showRadio
     */
    public function setShowRadio($showRadio)
    {
        $this->showRadio = $showRadio;
    }

    /**
     * @return mixed
     */
    public function getShowQueryBut()
    {
        return $this->showQueryBut;
    }

    /**
     * @param mixed $showQueryBut
     */
    public function setShowQueryBut($showQueryBut)
    {
        $this->showQueryBut = $showQueryBut;
    }

    /**
     * @return mixed
     */
    public function getShowExportBut()
    {
        return $this->showExportBut;
    }

    /**
     * @param mixed $showExportBut
     */
    public function setShowExportBut($showExportBut)
    {
        $this->showExportBut = $showExportBut;
    }

    /**
     * @return mixed
     */
    public function getFixedCheckbox()
    {
        return $this->fixedCheckbox;
    }

    /**
     * @param mixed $fixedCheckbox
     */
    public function setFixedCheckbox($fixedCheckbox)
    {
        $this->fixedCheckbox = $fixedCheckbox;
    }

    /**
     * @return mixed
     */
    public function getAllchecked()
    {
        return $this->allchecked;
    }

    /**
     * @param mixed $allchecked
     */
    public function setAllchecked($allchecked)
    {
        $this->allchecked = $allchecked;
    }

    /**
     * @return mixed
     */
    public function getFixedRadioBox()
    {
        return $this->fixedRadioBox;
    }

    /**
     * @param mixed $fixedRadioBox
     */
    public function setFixedRadioBox($fixedRadioBox)
    {
        $this->fixedRadioBox = $fixedRadioBox;
    }

    /**
     * @return mixed
     */
    public function getColsSort()
    {
        return $this->colsSort;
    }

    /**
     * @param mixed $colsSort
     */
    public function setColsSort($colsSort)
    {
        $this->colsSort = $colsSort;
    }

    /**
     * @return mixed
     */
    public function getSortCols()
    {
        return $this->sortCols;
    }

    /**
     * @param mixed $sortCols
     */
    public function setSortCols($sortCols)
    {
        $this->sortCols = $sortCols;
    }

    /**
     * @return mixed
     */
    public function getUnresize()
    {
        return $this->unresize;
    }

    /**
     * @param mixed $unresize
     */
    public function setUnresize($unresize)
    {
        $this->unresize = $unresize;
    }

    /**
     * @return mixed
     */
    public function getColsEditArr($i)
    {
        if(isset($this->colsEditArr[$i])) return $this->colsEditArr[$i];
        else return false;
    }

    /**
     * @param mixed $colsEditArr
     */
    public function setColsEditArr($colsEditArr)
    {
        $this->colsEditArr = $colsEditArr;
    }

    /**
     * @param mixed $colsEditArr
     */
    public function setColEdit($index,$edit = 'text')
    {
        $this->colsEditArr[$index] = $edit;
    }

    /**
     * @return mixed
     */
    public function getColsEventArr($i)
    {
        if(isset($this->colsEventArr[$i])) return $this->colsEventArr[$i];
        return false;
    }

    /**
     * @param mixed $colsEventArr
     */
    public function setColsEventArr($colsEventArr)
    {
        $this->colsEventArr = $colsEventArr;
    }

    /**
     * @return mixed
     */
    public function getColsStyleArr($i)
    {
        if(isset($this->colsStyleArr[$i])) return $this->colsStyleArr[$i];
        else return false;
    }

    /**
     * @param mixed $colsStyleArr
     */
    public function setColsStyleArr($colsStyleArr)
    {
        $this->colsStyleArr = $colsStyleArr;
    }

    /**
     * @return mixed
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * @param mixed $align
     */
    public function setAlign($align)
    {
        $this->align = $align;
    }

    /**
     * @return mixed
     */
    public function getIsMultistage()
    {
        return $this->isMultistage;
    }

    /**
     * @param mixed $isMultistage
     */
    public function setIsMultistage($isMultistage)
    {
        $this->isMultistage = $isMultistage;
    }

    /**
     * @return mixed
     */
    public function getMultistageHeader()
    {
        return $this->multistageHeader;
    }

    /**
     * @param mixed $multistageHeader
     */
    public function setMultistageHeader($multistageHeader)
    {
        $this->multistageHeader = $multistageHeader;
    }

    /**
     * @return mixed
     */
    public function getColsTempletArr($i)
    {
        if(isset($this->colsTempletArr[$i])) return $this->colsTempletArr[$i];
        else return false;
    }

    /**
     * @param mixed $colsTempletArr
     */
    public function setColsTempletArr($colsTempletArr)
    {
        $this->colsTempletArr = $colsTempletArr;
    }
    /**
     * @param mixed $colsTempletArr
     */
    public function setColTemplet($index,$templete)
    {
        $this->colsTempletArr[$index] = $templete;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getCellMinWidth()
    {
        return $this->cellMinWidth;
    }

    /**
     * @param mixed $cellMinWidth
     */
    public function setCellMinWidth($cellMinWidth)
    {
        $this->cellMinWidth = $cellMinWidth;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getInitSortDesc()
    {
        return $this->initSortDesc;
    }

    /**
     * @param mixed $initSortDesc
     */
    public function setInitSortDesc($initSortDesc)
    {
        $this->initSortDesc = $initSortDesc;
    }

    /**
     * @return mixed
     */
    public function getInitSortAsc()
    {
        return $this->initSortAsc;
    }

    /**
     * @param mixed $initSortAsc
     */
    public function setInitSortAsc($initSortAsc)
    {
        $this->initSortAsc = $initSortAsc;
    }

    /**
     * @return mixed
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * @param mixed $tableId
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }

    /**
     * @return mixed
     */
    public function getSkin()
    {
        return $this->skin;
    }

    /**
     * @param mixed $skin
     */
    public function setSkin($skin)
    {
        $this->skin = $skin;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getEven()
    {
        return $this->even;
    }

    /**
     * @param mixed $even
     */
    public function setEven($even)
    {
        $this->even = $even;
    }

    /**
     * @return mixed
     */
    public function getShowPage()
    {
        return $this->showPage;
    }

    /**
     * @param mixed $showPage
     */
    public function setShowPage($showPage)
    {
        $this->showPage = $showPage;
    }

    /**
     * @return mixed
     */
    public function getToolbar()
    {
        return $this->toolbar;
    }

    /**
     * @param mixed $toolbar
     */
    public function setToolbar($toolbar)
    {
        $this->toolbar = $toolbar;
    }

    /**
     * @return mixed
     */
    public function getToolbarId()
    {
        return $this->toolbarId;
    }

    /**
     * @param mixed $toolbarId
     */
    public function setToolbarId($toolbarId)
    {
        $this->toolbarId = $toolbarId;
    }

    /**
     * @return mixed
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * @param mixed $begin
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;
    }

    /**
     * @return mixed
     */
    public function getDataDictArr($index)
    {
        if(isset($this->dataDictArr[$index])) return $this->dataDictArr[$index];
        else return false;
    }

    /**
     * @param mixed $dataDictArr
     */
    public function setDataDictArr($dataDictArr)
    {
        $this->dataDictArr = $dataDictArr;
    }
    /**
     * @param mixed $dataDictArr
     */
    public function setDataDict($index,$dict)
    {
        $this->dataDictArr[$index] = $dict;
    }







}