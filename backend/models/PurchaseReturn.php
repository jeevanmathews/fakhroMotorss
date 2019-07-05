<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_return".
 *
 * @property int $id
 * @property int $grn_id
 * @property int $inv_id
 * @property int $prefix_id
 * @property string $prtn_number
 * @property string $prtn_created_date
 * @property string $prtn_date
 * @property int $prtn_created_by
 * @property int $supplier_id
 * @property double $subtotal
 * @property string $discount_type
 * @property double $discount
 * @property double $discount_percent
 * @property double $vat_percent
 * @property double $total_tax
 * @property double $grand_total
 * @property string $process_status
 * @property int $status
 */
class PurchaseReturn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_return';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grn_id', 'inv_id', 'prefix_id', 'prtn_created_by', 'supplier_id', 'status'], 'integer'],
            [['prefix_id', 'prtn_number', 'prtn_date', 'prtn_created_by', 'supplier_id'], 'required'],
            [['prtn_created_date'], 'safe'],
            [['subtotal', 'discount', 'discount_percent', 'vat_percent', 'total_tax', 'grand_total'], 'number'],
            [['remarks','process_status','discount_type'], 'string'],
            [['prtn_number'], 'string', 'max' => 200],
            [['prtn_date'], 'string', 'max' => 300],
            
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
            'inv_id' => 'Invoice',
            'prefix_id' => 'Prefix',
            'prtn_number' => 'Return Number',
            'prtn_created_date' => 'Return Created Date',
            'prtn_date' => 'Return Date',
            'prtn_created_by' => 'Return Created By',
            'supplier_id' => 'Supplier',
            'subtotal' => 'Subtotal',
            'discount_type' => 'Discount Type',
            'discount' => 'Discount',
            'discount_percent' => 'Discount Percent',
            'vat_percent' => 'Vat Percent',
            'total_tax' => 'Total Tax',
            'grand_total' => 'Grand Total',
            'process_status' => 'Process Status',
            'status' => 'Status',
        ];
    }
      public function getReturnitems()
    {
        return $this->hasMany(PurchaseReturnItems::className(), ['prtn_id' => 'id']);
    }
    public function getGrn()
    {
        return $this->hasOne(GoodsReceiptNote::className(), ['id' => 'grn_id']);
    }
    public function getPo()
    {
        return $this->hasOne(Purchaseorder::className(), ['id' => 'inv_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'prtn_created_by']);
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
