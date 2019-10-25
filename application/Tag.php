<?php
/**
 * User: Lynn
 * Date: 2019/4/15
 * Time: 15:54
 */

namespace app;


use common\dict\DictUtil;
use think\Db;
use think\template\TagLib;

class Tag extends TagLib
{
    protected $tags = [
        'radio' => ['attr'=>'label,name,code,value,inline,sql','close' => 0],
        'checkbox' => ['attr'=>'label,name,code,default,inline,skin,text,value,sql','close'=>0],
        'select' => ['attr'=>'label,name,code,default,inline,style,search,sql,value','close'=>0],
    ];



    /**
     * select 标签
     * @param $attr
     * @return string
     */
    public function tagSelect($attr){
        $html = '';
        $html .= isset($attr['label'])?'<label class="layui-form-label" >'.$attr['label'].'</label>':'';
        $inline = !empty($attr['inline'])?$attr['inline']:'block';
        $style = !empty($attr['style'])?'style="'.$attr['style'].'"':'';
        $html .= '<div class="layui-input-'.$inline.'" '.$style.'>';
        $html .= $this->renderSelectHtml($attr);
        $html .= '</div>';
//        echo htmlspecialchars($html);
        return $html;
    }

    /**
     * radio标签
     * @param $attr
     * @return string
     */
    public function tagRadio($attr){
        $html = '';
        $html .= isset($attr['label'])?'<label class="layui-form-label" >'.$attr['label'].'</label>':'';
        $inline = !empty($attr['inline'])?$attr['inline']:'block';
        $html .= '<div class="layui-input-'.$inline.'">';
        $html .= $this->renderRadioHtml($attr);
        $html .= '</div>';
        return $html;
    }

    /**
     * checkbox 标签
     * @param $attr
     * @return string
     */
    public function tagCheckbox($attr){
        $html = '';
        $html .= isset($attr['label'])?'<label class="layui-form-label" >'.$attr['label'].'</label>':'';
        $inline = !empty($attr['inline'])?$attr['inline']:'block';
        $html .= '<div class="layui-input-'.$inline.'">';
        $html .= $this->renderCheckboxHtml($attr);
        $html .= '</div>';
        return $html;
    }

    /**
     * 渲染select的html
     * @param $attr
     * @return string
     */
    protected function renderSelectHtml($attr){
        $valueList = [];
        if(isset($attr['sql'])) $valueList = $this->getSqlValue($attr['sql']);
        if(isset($attr['code'])) $valueList = DictUtil::getDictValue($attr['code']);
        $search = isset($attr['search'])?'lay-search':'';
        $html = '<select name="'.$attr['name'].'" lay-filter="'.$attr['name'].'" '.$search.'>';
        if(isset($attr['default']) && $attr['default'] == true){
            $html .= '<option value="">请选择</option>';
        }
        $value = isset($attr['value']) ? $this->autoBuildVar($attr['value']): null;
        foreach($valueList as $v){
            $selected = isset($attr['value']) ? '<?php if(isset('.$value.') && '.$value.' == \''.$v['val_code'].'\'): ?>selected<?php endif; ?>':'';
            $html .= '<option  value="'.$v['val_code'].'" '.$selected.'>'.$v['val_name'].'</option>';
        }
        $html .= '</select>';
        return $html;
    }


    /**
     * 渲染radio的html
     * @param $attr
     * @return string
     */
    protected function renderCheckboxHtml($attr){
        $html = '<input type="checkbox" name="'.$attr['name'].'" lay-filter="'.$attr['name'].'"';
        if(isset($attr['skin']) && $attr['skin'] != 'switch'){
            $valueList = [];
            if(isset($attr['sql'])) $valueList = $this->getSqlValue($attr['sql']);
            if(isset($attr['code'])) $valueList = DictUtil::getDictValue($attr['code']);
            $value = isset($attr['value']) ? $this->autoBuildVar($attr['value']): null;
            foreach($valueList as $v){
                $html .= '  value="'.$v['val_code'].'" title="'.$v['val_name'].'"';
                $html .= isset($attr['skin']) ? ' lay-skin="'.$attr['skin'].'"':'';
                $checked = isset($attr['value']) ? '<?php if(isset('.$value.') && '.$value.' == \''.$v['val_code'].'\'): ?>checked<?php endif; ?>':'';
                $html .= ' '.$checked;

            }
        }else{
            $html .= isset($attr['text']) ? ' lay-text="'.$attr['text'].'"':'';
            $html .= isset($attr['value']) ? ' value="'.$attr['value'].'"':'';
            $html .= isset($attr['skin']) ? ' lay-skin="'.$attr['skin'].'"':'';
            $default = isset($attr['default']) ? $this->autoBuildVar($attr['default']): null;
            $html .= (isset($attr['default']))?' <?php if((isset('.$default.') && '.$default.'== 1) || !isset('.$default.')): ?>checked<?php endif; ?>':'';
        }
            $html .= '>';
        return $html;
    }

    /**
     * 渲染radio的html
     * @param $code 字典code
     * @param $name 输入框name
     * @param $default 默认值
     * @return string
     */
    protected function renderRadioHtml($attr){
        $valueList = [];
        if(isset($attr['sql'])) $valueList = $this->getSqlValue($attr['sql']);
        if(isset($attr['code'])) $valueList = DictUtil::getDictValue($attr['code']);
        $html = '';
        $value = isset($attr['value']) ? $this->autoBuildVar($attr['value']): null;
        foreach($valueList as $v){
            $checked = isset($attr['value']) ? '<?php if(isset('.$value.') && '.$value.' == \''.$v['val_code'].'\'): ?>checked<?php endif; ?>':'';
            $html .= '<input type="radio" name="'.$attr['name'].'" lay-filter="'.$attr['name'].'" value="'.$v['val_code'].'" title="'.$v['val_name'].'" '.$checked.' >';
        }
        return $html;
    }

    /**
     * 根据sql获取数据
     * @param $sql
     * @return array
     */
    private function getSqlValue($sql){
        $resultList= Db::query($sql);
        $list = [];
        foreach($resultList as $v){
            $temp = array_values($v);
            $list[] = ['val_name'=>$temp[0],'val_code'=>$temp[1]];
        }
        return $list;
    }
}