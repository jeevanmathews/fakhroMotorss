<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_pricing".
 *
 * @property int $id
 * @property int $item_id
 * @property string $type
 * @property string $purchase_price
 * @property string $selling_price
 * @property string $created_date
 * @property int $status
 */
class Itempricing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_pricing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'type', 'purchase_price', 'selling_price'], 'required'],
            [['item_id', 'status'], 'integer'],
            [['type'], 'string'],
            [['created_date'], 'safe'],
            [['purchase_price', 'selling_price'], 'string', 'max' => 200],
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
            'type' => 'Type',
            'purchase_price' => 'Purchase Price',
            'selling_price' => 'Selling Price',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
    public function getItem()
    {
        return $this->hasOne(Items::className('yes'), ['id' => 'item_id']);
    }
}
