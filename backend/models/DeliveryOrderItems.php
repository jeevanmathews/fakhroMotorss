<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "delivery_order_items".
 *
 * @property int $id
 * @property int $do_id
 * @property int $item_id
 * @property int $so_quantity
 * @property int $quantity
 * @property int $unit_id
 * @property int $remaining_quantity
 * @property double $price
 * @property double $total_price 
 * @property string $dis_type 
 * @property float $discount_percentage
 * @property double $discount_amount
 * @property double $net_amount
 * @property double $vat_rate
 * @property double $tax
 * @property double $total
 * @property int $status
 */
class DeliveryOrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery_order_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_id', 'item_id', 'quantity', 'unit_id'], 'required'],//, 'price', 'tax', 'total'
            [['so_id', 'item_id', 'so_quantity', 'quantity', 'unit_id', 'status'], 'integer'],
            [['price', 'tax', 'total','remaining_quantity'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'do_id' => 'Do ID',
            'item_id' => 'Item ID',
            'so_quantity' => 'So Quantity',
            'quantity' => 'Quantity',
            'unit_id' => 'Unit ID',
            'price' => 'Price',
            'tax' => 'Tax',
            'total' => 'Total',
            'status' => 'Status',
        ];
    }
     public function getDeliveryOrder()
    {
        return $this->hasOne(DeliveryOrder::className(), ['id' => 'do_id']);
    }
     public function getUnit()
    {
        return $this->hasOne(Units::className(), ['id' => 'unit_id']);
    }
     public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    } 
}
