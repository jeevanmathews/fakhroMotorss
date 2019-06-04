<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $symbol
 * @property string $decimal_symbol
 * @property int $status
 * @property string $created_at
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'symbol', 'decimal_symbol'], 'string', 'max' => 100],
            [['name', 'symbol','code'], 'required'],
            [['code'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Currency Name',
            'code' => 'Code',
            'symbol' => 'Symbol',
            'decimal_symbol' => ' Symbol for decimal',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
