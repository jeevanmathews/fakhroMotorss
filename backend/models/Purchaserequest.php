<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_request".
 *
 * @property int $id
 * @property int $prefix_id
 * @property string $pr_number
 * @property int $requested_by
 * @property int $supplier_id
 * @property int $branch_id
 * @property string $request_date
 * @property string $expected_date
 * @property double $subtotal
 * @property string $discount_type
 * @property double $discount
 * @property double $discount_percent
 * @property double $vat_percent
 * @property double $total_tax
 * @property double $grand_total
 * @property string $process_status
 * @property string $remarks
 * @property int $status
 */
class Purchaserequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix_id','pr_number', 'requested_by', 'supplier_id', 'request_date', 'expected_date'], 'required'],//,'subtotal','total_tax','grand_total'
            [['requested_by', 'supplier_id', 'status','branch_id'], 'integer'],//'subtotal','discount','discount_percent','vat_percent','total_tax','grand_total',
            [['subtotal','discount','discount_percent','vat_percent','total_tax','grand_total'], 'number'],
            [['remarks'], 'string'],
            [['pr_number', 'request_date', 'expected_date'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pr_number' => 'PR Number',
            'requested_by' => 'Requested By',
            'supplier_id' => 'Supplier',
            'request_date' => 'Request Date',
            'expected_date' => 'Date',
            'prefix_id' => 'Prefix',
            'status' => 'Status',
        ];
    }
    public function getRequestitems()
    {
        return $this->hasMany(Purchaserequestitems::className(), ['pr_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'requested_by']);
    }
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }
     public function getPo()
    {
        return $this->hasOne(Purchaseorder::className(), ['pr_id' => 'id']);
    }
    public function getPrefix()
    {
        return $this->hasOne(PrefixMaster::className(), ['id' => 'prefix_id']);
    }
}
