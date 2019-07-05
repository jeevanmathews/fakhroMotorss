<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_invoice".
 *
 * @property int $id
 * @property int $grn_id 
 * @property int $po_id
 * @property int $prefix_id
 * @property int $branch_id
 * @property string $inv_number
 * @property string $inv_created_date
 * @property string $inv_date
 * @property int $inv_created_by
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
class PurchaseInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grn_id', 'prefix_id', 'inv_created_by', 'supplier_id','branch_id', 'status'], 'integer'],
            [['prefix_id', 'inv_number', 'inv_date', 'inv_created_by', 'supplier_id'], 'required'],
            [['inv_created_date'], 'safe'],
          [['remarks','process_status','discount_type'], 'string'],
            [['subtotal','discount','discount_percent','vat_percent','total_tax','grand_total'], 'number'],
            [['inv_number'], 'string', 'max' => 200],
            [['inv_date'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grn_id' => 'GRN',
            'po_id' => 'PO',
            'prefix_id' => 'Prefix',
            'inv_number' => 'Invoice Number',
            'inv_created_date' => 'Invoice Created Date',
            'inv_date' => 'Invoice Date',
            'inv_created_by' => 'Invoice Created By',
            'supplier_id' => 'Supplier',
            'subtotal' => 'Subtotal',
            'discount' => 'Discount',
            'total_tax' => 'Total Tax',
            'grand_total' => 'Grand Total',
            'status' => 'Status',
        ];
    }
      public function getInvoiceitems()
    {
        return $this->hasMany(PurchaseInvoiceItems::className(), ['inv_id' => 'id']);
    }
    public function getGrn()
    {
        return $this->hasOne(GoodsReceiptNote::className(), ['id' => 'grn_id']);
    }
    public function getPo()
    {
        return $this->hasOne(Purchaseorder::className(), ['id' => 'po_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'inv_created_by']);
    }
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }
    public function getPrefix()
    {
        return $this->hasOne(PrefixMaster::className(), ['id' => 'prefix_id']);
    }
}
