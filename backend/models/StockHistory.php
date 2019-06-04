<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stock_history".
 *
 * @property int $id
 * @property string $type
 * @property int $item_id
 * @property int $order_id
 * @property int $jobcard_id
 * @property int $branch_id
 * @property double $opening_stock
 * @property double $previous_stock
 * @property double $reduced_stock
 * @property double $current_stock
 * @property string $date
 */
class StockHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'item_id', 'branch_id', 'opening_stock', 'previous_stock', 'reduced_stock', 'current_stock', 'date'], 'required'],
            [['type'], 'string'],
            [['item_id', 'order_id', 'jobcard_id', 'branch_id'], 'integer'],
            [['opening_stock', 'previous_stock', 'reduced_stock', 'current_stock'], 'number'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'item_id' => 'Item ID',
            'order_id' => 'Order ID',
            'jobcard_id' => 'Jobcard ID',
            'branch_id' => 'Branch ID',
            'opening_stock' => 'Opening Stock',
            'previous_stock' => 'Previous Stock',
            'reduced_stock' => 'Reduced Stock',
            'current_stock' => 'Current Stock',
            'date' => 'Date',
        ];
    }
}
