<?php

namespace common\components;

use Yii;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**

 */
class AutoForm extends ActiveForm
{

   public function init()
    {
        parent::init();
        $this->fieldClass = 'common\components\AutoField'; 
        $this->options = $this->options+["class" => "aerp-form"];      
    }
}