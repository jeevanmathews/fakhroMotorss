<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_receipt_note".
 *
 * @property int $id
 * @property int $po_id
 * @property int $prefix_id
 * @property string $grn_number
 * @property string $grn_created_date
 * @property string $grn_date
 * @property int $grn_created_by
 * @property int $supplier_id
 * @property double $subtotal
 * @property double $discount_type
 * @property double $discount
 * @property double $discount_percent
 * @property double $vat_percent
 * @property double $total_tax
 * @property double $grand_total
 * @property string $process_status
 * @property string $remarks
 * @property int $status
 */
class GoodsReceiptNote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_receipt_note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix_id','po_id', 'grn_created_by', 'supplier_id', 'status','branch_id'], 'integer'],
            [['prefix_id','grn_number', 'grn_date', 'grn_created_by', 'supplier_id'], 'required'],//, 'subtotal', 'total_tax', 'grand_total'
            [['grn_created_date'], 'safe'],
            [['remarks'], 'string'],
            [['subtotal','discount','discount_percent','vat_percent','total_tax','grand_total'], 'number'],
            [['grn_number'], 'string', 'max' => 200],
            [['grn_date', 'subtotal', 'total_tax', 'grand_total'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'po_id' => 'PO',
            'prefix_id' => 'Prefix',
            'grn_number' => 'GRN Number',
            'grn_created_date' => 'GRN Created Date',
            'grn_date' => 'GRN Date',
            'grn_created_by' => 'GRN Created By',
            'supplier_id' => 'Supplier ID',
            'subtotal' => 'Subtotal',
            'total_tax' => 'Total Tax',
            'grand_total' => 'Grand Total',
            'status' => 'Status',
        ];
    }
      public function getGrnitems()
    {
        return $this->hasMany(GrnItems::className(), ['grn_id' => 'id']);
    }
      public function getPo()
    {
        return $this->hasOne(Purchaseorder::className(), ['id' => 'po_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'grn_created_by']);
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
