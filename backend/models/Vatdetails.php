<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vat_details".
 *
 * @property int $id
 * @property string $name
 * @property int $rate
 * @property string $created_date
 * @property int $status
 */
class Vatdetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vat_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'rate'], 'required'],
            [['rate', 'status'], 'integer'],
            [['created_date'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'rate' => 'Rate %',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
}
