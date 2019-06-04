<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sales_order".
 *
 * @property int $id
 * @property int $qtn_id
 * @property int $prefix_id
 * @property string $so_number
 * @property string $so_date
 * @property string $so_expected_date
 * @property int $so_created_by
 * @property int $customer_id
 * @property string $subtotal
 * @property double $discount_type
 * @property double $discount
 * @property double $discount_percent
 * @property double $vat_percent
 * @property string $total_tax
 * @property string $grand_total
 * @property int $status
 */
class SalesOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_order';
    }

    /**
     * {@inheritdoc}
     */
	public function rules()
    {
        return [
            [[ 'prefix_id','so_number', 'so_expected_date', 'so_created_by'], 'required'],//, 'subtotal', 'total_tax', 'grand_total'
            [['qtn_id', 'so_created_by', 'status'], 'integer'],
            [['so_date'], 'safe'],
            [['so_number'], 'string', 'max' => 200],
            [['so_expected_date', 'subtotal', 'total_tax', 'grand_total'], 'string', 'max' => 300],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qtn_id' => 'Quotation',
            'prefix_id' => 'Prefix',
            'so_number' => 'SO Number',
            'so_date' => 'SO Date',
            'so_expected_date' => 'SO Expected Date',
            'so_created_by' => 'SO Created By',
            'customer_id' => 'Customer',
            'subtotal' => 'Subtotal',
            'total_tax' => 'Total Tax',
            'grand_total' => 'Grand Total',
            'status' => 'Status',
        ];
    }
  public function getOrderitems()
    {
        return $this->hasMany(SalesOrderItems::className(), ['so_id' => 'id']);
    }
      public function getQtn()
    {
        return $this->hasOne(Qutation::className(), ['id' => 'qtn_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'so_created_by']);
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

   
