<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "variant_features".
 *
 * @property int $id
 * @property int $variant_id
 * @property int $feature_id
 * @property string $value
 * @property string $created_date
 * @property int $status
 */
class Variantfeatures extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variant_features';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['variant_id', 'feature_id'], 'required'],
            [['variant_id', 'feature_id', 'status'], 'integer'],
            [['value'], 'string'],
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
            'variant_id' => 'Variant ID',
            'feature_id' => 'Feature ID',
            'value' => 'Value',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
     public function getVariant()
    {
        return $this->hasMany(Variants::className(), ['id' => 'variant_id']);
    }
     public function getFeature()
    {
        return $this->hasOne(Customfeatures::className(), ['id' => 'feature_id']);
    }
     public function getItemfeature()
    {
        return $this->hasOne(Itemfeature::className(), ['value_id' => 'id']);
    }
}
