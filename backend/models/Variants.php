<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "variants".
 *
 * @property int $id
 * @property int $model_id
 * @property string $name
 * @property double $price
 * @property string $created_date
 * @property int $status
 */
class Variants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'name'], 'required'],
            [['model_id', 'status'], 'integer'],
            [['price'], 'number'],
            [['created_date'], 'safe'],
            ['name', 'unique'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'name' => 'Variant',
            'price' => 'Price',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
    public function getModel()
        {
            return $this->hasOne(Vehiclemodels::className(), ['id' => 'model_id']);
        }
    public function getVariantfeatures()
    {
        return $this->hasMany(Variantfeatures::className(), ['variant_id' => 'id']);
    }

    public function variantfeaturesArray(){
        $final = [];
        foreach ($this->variantfeatures as $variantfeature) { 
            $values = [];                 
            if(array_key_exists($variantfeature->feature_id, $final)){
                $values = $final[$variantfeature->feature_id]['values'];
            }
            $values[] = $variantfeature->value;
            $final[$variantfeature->feature_id] = ["name" => $variantfeature->feature->name, 'values' => $values];
        }
        return $final;
    }
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['variant_id' => 'id']);
    }
}
