<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_stock".
 *
 * @property int $id
 * @property int $item_id
 * @property double $quantity
 * @property double $opening_stock
 * @property double $closing_stock
 * @property string $type
 * @property string $created_date
 * @property int $status
 */
class ItemStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'quantity', 'opening_stock', 'closing_stock'], 'required'],
            [['item_id', 'status'], 'integer'],
            [['quantity', 'opening_stock', 'closing_stock'], 'number'],
            [['type'], 'string'],
            [['created_date'], 'safe'],
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
            'quantity' => 'Quantity',
            'opening_stock' => 'Opening Stock',
            'closing_stock' => 'Closing Stock',
            'type' => 'Type',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
}
