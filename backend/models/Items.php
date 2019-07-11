<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property int $model_id
 * @property string $item_code
 * @property string $item_name
 * @property string $description
 * @property string $manufacturing_date
 * @property int $variant_id
 * @property int $supplier_id
 * @property double $opening_stock
 * @property double $current_stock
 * @property string $tax_enabled
 * @property string $vat
 * @property double $tax_rate
 * @property string $created_date
 * @property string $type 
 * @property int $itemgroup_id
 * @property int $unit_id
 * @property int $status
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name','item_code','supplier_id'], 'required'],
            [['model_id', 'unit_id','variant_id', 'status','supplier_id','itemgroup_id'], 'integer'],
            [['item_name','type'], 'string', 'max' => 300],
            [['description','tax_enabled'], 'string'],
            [['current_stock','opening_stock','tax_rate'], 'number'],
            [['created_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model',
            'item_name' => 'Item Name',
            'item_code' => 'Code',
            'description' => 'Item Description',
            'supplier_id'=>'Supplier',
            'variant_id' => 'Variant',
            'unit_id' => 'Unit',
            'opening_stock' => 'Opening Stock',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
    public function getModel()
    {
        return $this->hasOne(Vehiclemodels::className('yes'), ['id' => 'model_id']);
    }
    public function getPricing()
    {
        return $this->hasOne(Itempricing::className('yes'), ['item_id' => 'id']);
    }
    public function getItemgroup()
    {
        return $this->hasOne(Itemgroup::className('yes'), ['id' => 'itemgroup_id']);
    }
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className('yes'), ['id' => 'supplier_id']);
    }
     public function getUnit()
    {
        return $this->hasOne(Units::className('yes'), ['id' => 'unit_id']);
    }
     public function getPurchasereqitems()
    {
        return $this->hasOne(Purchaserequestitems::className(), ['item_id' => 'id']);
    } 
    public function getVariant()
    {
        return $this->hasOne(Variants::className(), ['id' => 'variant_id']);
    }
    public function getItemfeature()
    {
        return $this->hasMany(Itemfeature::className(), ['item_id' => 'id']);
    }
    public function featuresnValues(){
        $final = [];
        foreach ($this->itemfeature as $feature) { 
            // var_dump($feature);
            $values = [];                 
            if(array_key_exists($feature->feature_id, $final)){
                $values = $final[$feature->feature_id]['values'];
            }
            // var_dump($feature->featurevalue);
            $values[] = $feature->featurevalue->value;
            $final[$feature->feature_id] = ["name" => $feature->feature->name, 'values' => $values];
        }
        return $final;
    }
    public function getRate(){ 
        $price = Itempricing::find()->where(["item_id" => $this->id, 'type' => $this->type])->one();
       return ($price)?$price->selling_price:0;
   }
   public function getNamewithPrice(){
        return $this->item_name." - ".Yii::$app->common->company->settings->currency->code. " " .$this->rate." /unit";
   }
   public function currentStock($item_id){
        $model= StockHistory::find()->where(['item_id' => $item_id,'branch_id'=>Yii::$app->user->identity->branch_id])->orderBy('id desc')->limit(1)->one();
        return(isset($model->current_stock)?$model->current_stock:0);
   }
}
