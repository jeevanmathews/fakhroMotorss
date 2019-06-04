<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "delivery_order".
 *
 * @property int $id
 * @property int $so_id 
 * @property int $prefix_id
 * @property string $do_number
 * @property string $do_created_date
 * @property string $do_date
 * @property int $do_created_by
 * @property int $customer_id
 * @property string $subtotal
 * @* @property double $discount_type
 * @property double $discount
 * @property double $discount_percent
 * @property double $vat_percent
 * @property string $total_tax
 * @property string $grand_total
 * @property int $status
 */
class DeliveryOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix_id','so_id', 'do_created_by', 'customer_id', 'status'], 'integer'],
            [['do_number', 'do_date', 'do_created_by', 'customer_id', 'subtotal', 'total_tax', 'grand_total'], 'required'],
            [['do_created_date'], 'safe'],
            [['do_number'], 'string', 'max' => 200],
            [['do_date', 'subtotal', 'total_tax', 'grand_total'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'so_id' => 'So ID',
            'do_number' => 'Do Number',
            'prefix_id' => 'Prefix',
            'do_created_date' => 'Do Created Date',
            'do_date' => 'Do Date',
            'do_created_by' => 'Do Created By',
            'customer_id' => 'Customer ID',
            'subtotal' => 'Subtotal',
            'total_tax' => 'Total Tax',
            'grand_total' => 'Grand Total',
            'status' => 'Status',
        ];
    }
    public function getOrderitems()
    {
        return $this->hasMany(DeliveryOrderItems::className(), ['do_id' => 'id']);
    }
      public function getSo()
    {
        return $this->hasOne(SalesOrder::className(), ['id' => 'so_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'do_created_by']);
    }
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
    public function getPrefix()
    {
        return $this->hasOne(PrefixMaster::className(), ['id' => 'prefix_id']);
    }
}
