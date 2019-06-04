<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property int $id 
 * @property string $prefix_id
 * @property string $po_number
 * @property string $po_date
 * @property string $po_expected_date
 * @property int $po_created_by
 * @property int $supplier_id
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
class Purchaseorder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix_id', 'po_number', 'po_expected_date', 'po_created_by'], 'required'],//, 'subtotal', 'total_tax', 'grand_total'
            [['pr_id', 'po_created_by', 'status','branch_id'], 'integer'],
            [['po_date'], 'safe'],
            [['subtotal','discount','discount_percent','vat_percent','total_tax','grand_total'], 'number'],
            [['po_number'], 'string', 'max' => 200],
            [['po_expected_date', 'subtotal', 'total_tax', 'grand_total'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pr_id' => 'Pr ID',
            'prefix_id' => 'Prefix',
            'po_number' => 'Po Number',
            'po_date' => 'Po Date',
            'po_expected_date' => 'Po Expected Date',
            'po_created_by' => 'Po Created By',
            'subtotal' => 'Subtotal',
            'total_tax' => 'Total Tax',
            'grand_total' => 'Grand Total',
            'status' => 'Status',
        ];
    }
    public function getOrderitems()
    {
        return $this->hasMany(Purchaseorderitems::className(), ['po_id' => 'id']);
    }
      public function getPr()
    {
        return $this->hasOne(Purchaserequest::className(), ['id' => 'pr_id']);
    }
    public function getInvoice()
    {
        return $this->hasOne(PurchaseInvoice::className(), ['po_id' => 'id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'po_created_by']);
    }
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }
      public function getGrn()
    {
        return $this->hasOne(GoodsReceiptNote::className(), ['po_id' => 'id']);
    }
    public function getPrefix()
    {
        return $this->hasOne(PrefixMaster::className(), ['id' => 'prefix_id']);
    }
}
