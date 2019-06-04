<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "custom_features".
 *
 * @property int $id
 * @property string $name
 * @property string $multiple
 * @property string $value
 * @property int $status
 */
class Customfeatures extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'custom_features';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],       
            [['status'], 'integer'],
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
            'name[]' => 'Name', 
            'status' => 'Status',
        ];
    }
     public function getFeatures()
    {
        return $this->hasOne(Variantfeatures::className(), ['feature_id' => 'id']);
    }
     public function getItemfeature()
    {
        return $this->hasOne(Itemfeature::className(), ['feature_id' => 'id']);
    }
    
}
