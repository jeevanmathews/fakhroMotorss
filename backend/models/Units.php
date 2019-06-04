<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "units".
 *
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property string $code
 * @property int $decimal_places
 * @property string $created_at
 * @property int $status
 */
class Units extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'units';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['decimal_places', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 300],
            [['symbol'], 'string', 'max' => 200],
            [['code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'symbol' => 'Symbol',
            'code' => 'Code',
            'decimal_places' => 'Decimal Places',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
     public function getItem()
    {
        return $this->hasOne(Items::className('yes'), ['unit_id' => 'id']);
    }
     public function getPurchaserequestitems()
    {
        return $this->hasOne(Purchaserequestitems::className(), ['unit_id' => 'id']);
    }
}
