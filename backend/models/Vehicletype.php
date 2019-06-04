<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vehicle_types".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class Vehicletype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 250],
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
            'status' => 'Status',
        ];
    }
      public function getModel()
    {
        return $this->hasMany(Vehicletype::className(), ['type_id' => 'id']);
    }
}
