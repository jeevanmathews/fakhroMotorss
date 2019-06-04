<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "grn_items".
 *
 * @property int $id
 * @property int $grn_id
 * @property int $item_id
 * @property int $po_quantity
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
class GrnItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grn_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grn_id', 'item_id', 'quantity', 'unit_id'], 'required'],//, 'price', 'tax', 'total'
            [['grn_id', 'item_id', 'po_quantity', 'quantity', 'unit_id', 'status'], 'integer'],
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
            'grn_id' => 'Grn ID',
            'item_id' => 'Item ID',
            'po_quantity' => 'PO Quantity',
            'quantity' => 'Quantity',
            'unit_id' => 'Unit ID',
            'price' => 'Price',
            'tax' => 'Tax',
            'total' => 'Total',
            'status' => 'Status',
        ];
    }
   public function getGrn()
    {
        return $this->hasOne(GoodsReceiptNote::className(), ['id' => 'grn_id']);
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
