<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Quotation".
 *
 * @property int $id
 * @property string $qtn_number
 * @property int $prefix_id
 * @property int $requested_by
 * @property int $customer_id
 * @property string $request_date
 * @property string $expected_date
 * @property double $subtotal
 * @property double $discount_type
 * @property double $discount
 * @property double $discount_percent
 * @property double $vat_percent
 * @property double $total_tax
 * @property double $grand_total
 * @property int $status
 */
class Quotation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Qutation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix_id','qtn_number', 'requested_by', 'customer_id', 'request_date', 'expected_date'], 'required'],//,'subtotal','total_tax','grand_total'
            [['requested_by', 'customer_id', 'status'], 'integer'],
            //[['request_date'], 'safe'],
            [['qtn_number', 'request_date', 'expected_date'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qtn_number' => 'QTN Number',
            'requested_by' => 'Requested By',
            'prefix_id' => 'Prefix',
            'customer_id' => 'Customer',
            'request_date' => 'Request Date',
            'expected_date' => 'Expected Date',
            'subtotal' => 'Subtotal',
            'discount' => 'Discount',
            'total_tax' => 'Total Tax',
            'grand_total' => 'Grand Total',
            'status' => 'Status',
        ];
    }
public function getRequestitems()
    {
        return $this->hasMany(Quotationitems::className(), ['qtn_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'requested_by']);
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