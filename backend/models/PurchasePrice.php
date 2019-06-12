<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_price".
 *
 * @property int $id
 * @property string $code
 * @property int $item_id
 * @property int $stock_id
 * @property double $purchase_price
 * @property int $status
 */
class PurchasePrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stock_id','code', 'item_id', 'purchase_price'], 'required'],
            [['stock_id','item_id', 'status'], 'integer'],
            [['purchase_price'], 'number'],
            [['code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'item_id' => 'Item ID',
            'purchase_price' => 'Purchase Price',
            'status' => 'Status',
        ];
    }
}
