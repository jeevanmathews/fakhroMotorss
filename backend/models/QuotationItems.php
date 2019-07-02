<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "qutation_items".
 *
 * @property int $id
 * @property int $qtn_id
 * @property int $item_id
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
class QuotationItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qutation_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pr_id', 'item_id', 'quantity', 'unit_id', 'price', 'total'], 'required'],
            [['quantity','remaining_quantity','price','total_price','discount_percentage','discount_amount','net_amount','vat_rate','tax','total'], 'integer'],
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
            'qtn_id' => 'Qtn ID',
            'item_id' => 'Item ID',
            'quantity' => 'Quantity',
            'unit_id' => 'Unit ID',
            'price' => 'Price',
            'tax' => 'Tax',
            'total' => 'Total',
            'status' => 'Status',
        ];
    }
	public function getQutation()
	{
		return $this->hasOne(Quotation::className(), ['id' => 'pr_id']);
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
