<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_pricing".
 *
 * @property int $id
 * @property int $item_id
 * @property string $type
 * @property double $purchase_price
 * @property double $selling_price
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
            [['purchase_price', 'selling_price'], 'number'],
            [['type'], 'string'],
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
