<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sales_invoice_items".
 *
 * @property int $id
 * @property int $inv_id
 * @property int $item_id
 * @property int $do_quantity
 * @property int $quantity
 * @property double $remaining_quantity
 * @property int $unit_id
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
class SalesInvoiceItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_invoice_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inv_id', 'item_id', 'quantity', 'unit_id'], 'required'],
            [['inv_id', 'item_id', 'do_quantity', 'quantity', 'unit_id','remaining_quantity', 'status'], 'number'],
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
            'inv_id' => 'Inv ID',
            'item_id' => 'Item ID',
            'do_quantity' => 'Do Quantity',
            'quantity' => 'Quantity',
            'unit_id' => 'Unit ID',
            'price' => 'Price',
            'tax' => 'Tax',
            'total' => 'Total',
            'status' => 'Status',
        ];
    }

            public function getSalesInvoice()
    {
        return $this->hasOne(DeliveryOrder::className(), ['id' => 'inv_id']);
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
