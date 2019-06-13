<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jobcard_material".
 *
 * @property int $id
 * @property int $material_id
 * @property string $material_type
 * @property int $num_unit
 * @property double $unit_rate
 * @property double $rate
 */
class JobcardMaterial extends \yii\db\ActiveRecord
{
    public $discount;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobcard_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['material_id', 'material_type'], 'required'],
            [['material_id', 'num_unit', 'jobcard_id'], 'integer'],          
            [['material_type', 'discount'], 'string'],
            [['unit_rate', 'rate', 'total', 'tax_rate', 'tax_amount', 'discount_percent', 'discount_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_id' => 'Material ID',
            'material_type' => 'Material Type',
            'num_unit' => 'No of Units',
            'unit_rate' => 'Unit Cost',
            'rate' => 'Material Cost',
            'tax_rate' => 'Tax Rate (%)'
        ];
    }

    public function getJobcard()
    {
        return $this->hasOne(Jobcard::className(), ['id' => 'jobcard_id']);
    }

    public function getMaterial(){
        if($this->material_type == "accessories"){
            $material = Accessories::findOne($this->material_id);
        }else{
            $material = Spareparts::findOne($this->material_id);
        }
        return $material;
    }    

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            if($this->isNewRecord){
                if(static::find()->where(["jobcard_id" => $this->jobcard_id, 'material_type' => $this->material_type, 'material_id' => $this->material_id])->count()){
                    $this->addError("material_id", "Material Already added to this Jobcard");
                    return false;
                }
            }
            if($stock = StockHistory::find()->where(['type' => $this->material_type, 'item_id' => $this->material_id])->orderBy('id desc')->limit(1)->one()){
                    if($stock->current_stock < $this->num_unit){
                        $this->addError("material_id", "Material stock is less than the required entry.");
                        return false;
                    }                    
            }else{
                $this->addError("material_id", "Material stock is not added yet.");
                return false;
            }
            
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);      
        Jobcard::updateTotals($this->jobcard_id);
    }
}
