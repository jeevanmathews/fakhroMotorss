<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_order_items".
 *
 * @property int $id
 * @property int $po_id
 * @property int $item_id
 * @property int $pr_quantity
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
class Purchaseorderitems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_order_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['po_id', 'item_id', 'quantity', 'unit_id'], 'required'],//, 'price', 'tax', 'total'
            [['po_id', 'item_id', 'pr_quantity', 'quantity', 'unit_id', 'status'], 'integer'],
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
            'po_id' => 'Po ID',
            'item_id' => 'Item ID',
            'pr_quantity' => 'Pr Quantity',
            'quantity' => 'Quantity',
            'unit_id' => 'Unit ID',
            'price' => 'Price',
            'tax' => 'Tax',
            'total' => 'Total',
            'status' => 'Status',
        ];
    }

      public function getPurchaseorder()
    {
        return $this->hasOne(Purchaseorder::className(), ['id' => 'po_id']);
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
