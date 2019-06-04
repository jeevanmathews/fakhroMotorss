<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jobcard_invoice_material".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $material_id
 * @property string $material_type
 * @property double $unit_rate
 * @property int $num_unit
 * @property double $total
 * @property double $discount_percent
 * @property double $discount_amount
 * @property string $tax_enabled
 * @property double $tax_rate
 * @property double $tax_amount
 * @property double $rate
 */
class JobcardInvoiceMaterial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobcard_invoice_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'material_id', 'material_type', 'tax_enabled'], 'required'],
            [['invoice_id', 'material_id', 'num_unit'], 'integer'],
            [['material_type', 'tax_enabled'], 'string'],
            [['unit_rate', 'total', 'discount_percent', 'discount_amount', 'tax_rate', 'tax_amount', 'rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'material_id' => 'Material ID',
            'material_type' => 'Material Type',
            'unit_rate' => 'Unit Rate',
            'num_unit' => 'Num Unit',
            'total' => 'Total',
            'discount_percent' => 'Discount Percent',
            'discount_amount' => 'Discount Amount',
            'tax_enabled' => 'Tax Enabled',
            'tax_rate' => 'Tax Rate',
            'tax_amount' => 'Tax Amount',
            'rate' => 'Rate',
        ];
    }

    public function getMaterial(){
        if($this->material_type == "accessories"){
            $material = Accessories::findOne($this->material_id);
        }else{
            $material = Spareparts::findOne($this->material_id);
        }
        return $material;
    } 
}
