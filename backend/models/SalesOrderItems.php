<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sales_order_items".
 *
 * @property int $id
 * @property int $so_id
 * @property int $item_id
 * @property int $qtn_quantity
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

class SalesOrderItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_order_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['so_id', 'item_id', 'quantity', 'unit_id'], 'required'],//, 'price', 'tax', 'total'
            [['so_id', 'item_id', 'qtn_quantity', 'quantity', 'unit_id', 'status'], 'integer'],
            [['price', 'tax', 'total'], 'number'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'so_id' => 'SO',
            'item_id' => 'Item ID',
            'qtn_quantity' => 'QTN Quantity',
            'quantity' => 'Quantity',
            'unit_id' => 'Unit',
            'price' => 'Price',
            'tax' => 'Tax',
            'total' => 'Total',
            'status' => 'Status',
        ];
    }
    public function getSalesOrder()
    {
        return $this->hasOne(SalesOrder::className(), ['id' => 'so_id']);
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
