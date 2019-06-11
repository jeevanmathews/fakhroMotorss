<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stock_distribution".
 *
 * @property int $id
 * @property int $item_id
 * @property string $code
 * @property string $type
 * @property int $order_id
 * @property int $jobcard_id
 * @property double $opening_stock
 * @property double $previous_stock
 * @property double $reduced_stock
 * @property double $current_stock
 */
class StockDistribution extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_distribution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'opening_stock', 'previous_stock', 'current_stock'], 'required'],
            [['item_id','order_id','jobcard_id'], 'integer'],
            [['opening_stock', 'previous_stock', 'reduced_stock', 'current_stock'], 'number'],
            [['code','type'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'code' => 'Code',
            'opening_stock' => 'Opening Stock',
            'previous_stock' => 'Previous Stock',
            'reduced_stock' => 'Reduced Stock',
            'current_stock' => 'Current Stock',
        ];
    }
}
