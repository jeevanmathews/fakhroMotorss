<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_feature".
 *
 * @property int $id
 * @property int $item_id
 * @property int $feature_id
 * @property int $value_id
 * @property string $created_date
 * @property int $status
 */
class Itemfeature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'feature_id'], 'required'],
            [['item_id', 'feature_id', 'status'], 'integer'],
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
            'item_id' => 'Item ID',
            'feature_id' => 'Feature ID',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    }
    public function getFeature()
    {
        return $this->hasOne(Customfeatures::className(), ['id' => 'feature_id']);
    }
     public function getFeaturevalue()
    {
        return $this->hasOne(Variantfeatures::className(), ['id' => 'value_id']);
    }

  public function featuresnValues(){
         $final = [];
        foreach ($this->itemfeature as $variantfeature) { 
            $values = [];                 
            if(array_key_exists($variantfeature->feature_id, $final)){
                $values = $final[$variantfeature->feature_id]['values'];
            }
            $values[] = $variantfeature->value;
            $final[$variantfeature->feature_id] = ["name" => $variantfeature->feature->name, 'values' => $values];
        }
        return $final;
    }
}
