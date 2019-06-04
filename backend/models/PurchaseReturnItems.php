<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_return_items".
 *
 * @property int $id
 * @property int $prtn_id
 * @property int $item_id
 * @property int $grn_quantity
 * @property int $quantity
 * @property double $remaining_quantity
 * @property int $unit_id
 * @property double $price
 * @property double $total_price
 * @property string $dis_type
 * @property double $discount_percentage
 * @property double $discount_amount
 * @property double $net_amount
 * @property double $vat_rate
 * @property double $tax
 * @property double $total
 * @property int $status
 */
class PurchaseReturnItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_return_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prtn_id', 'item_id', 'quantity', 'unit_id', 'total_price'], 'required'],
            [['prtn_id', 'item_id', 'grn_quantity', 'quantity', 'unit_id', 'status'], 'integer'],
            [['remaining_quantity', 'price', 'total_price', 'discount_percentage', 'discount_amount', 'net_amount', 'vat_rate', 'tax', 'total'], 'number'],
            [['dis_type'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prtn_id' => 'Prtn ID',
            'item_id' => 'Item ID',
            'grn_quantity' => 'Grn Quantity',
            'quantity' => 'Quantity',
            'remaining_quantity' => 'Remaining Quantity',
            'unit_id' => 'Unit ID',
            'price' => 'Price',
            'total_price' => 'Total Price',
            'dis_type' => 'Dis Type',
            'discount_percentage' => 'Discount Percentage',
            'discount_amount' => 'Discount Amount',
            'net_amount' => 'Net Amount',
            'vat_rate' => 'Vat Rate',
            'tax' => 'Tax',
            'total' => 'Total',
            'status' => 'Status',
        ];
    }
     public function getReturn()
    {
        return $this->hasOne(PurchaseReturn::className(), ['id' => 'prtn_id']);
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
