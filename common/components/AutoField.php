<?php

namespace common\components;

use Yii;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**

 */
class AutoField extends ActiveField
{

	private $_skipLabelFor = false;

   public function init()
    {
        parent::init();
        $this->template = "<div class='input-group'>{label}{input}</div>{hint}{error}";    
    }

    /**
     * Generates a label tag for [[attribute]].
     * @param null|string|false $label the label to use. If `null`, the label will be generated via [[Model::getAttributeLabel()]].
     * If `false`, the generated field will not contain the label part.
     * Note that this will NOT be [[Html::encode()|encoded]].
     * @param null|array $options the tag options in terms of name-value pairs. It will be merged with [[labelOptions]].
     * The options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded
     * using [[Html::encode()]]. If a value is `null`, the corresponding attribute will not be rendered.
     * @return $this the field object itself.
     */
    public function label($label = null, $options = [])
    {
        if ($label === false) {
            $this->parts['{label}'] = '';
            return $this;
        }
        $options = array_merge($this->labelOptions, $options);
        if ($label !== null) {
            $options['label'] = $label;
        }
        if ($this->_skipLabelFor) {
            $options['for'] = null;
        }
        $this->parts['{label}'] = '<div class="input-group-addon">'.
                   $this->model->getAttributeLabel($this->attribute). 
                  '</div>';
        return $this;
    }

    public function textarea($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);        
        $options["placeholder"] = $this->model->getAttributeLabel($this->attribute);
        
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);
        $this->template = "{input}{hint}{error}";
        return $this;
    }
  

}