<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "make".
 *
 * @property int $id
 * @property string $make
 * @property int $manufacturer_id
 * @property int $status
 */
class Make extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'make';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['make', 'manufacturer_id'], 'required'],
            [['manufacturer_id', 'status'], 'integer'],
            [['make'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'make' => 'Make',
            'manufacturer_id' => 'Manufacturer ID',
            'status' => 'Status',
        ];
    }

    public function getManufacturer()
    {
        return $this->hasOne(Manufacturer::className(), ['id' => 'manufacturer_id']);
    }
}
