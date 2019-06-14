<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "model".
 *
 * @property int $id
 * @property int $make_id
 * @property string $model
 * @property int $status
 */
class CarModel extends \yii\db\ActiveRecord
{
    public $manufacturer;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['make_id', 'model', 'status'], 'required'],
            [['make_id', 'status'], 'integer'],
            [['model'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'make_id' => 'Make ID',
            'model' => 'Model',
            'status' => 'Status',
        ];
    }

    public function getMake(){
        return $this->hasOne(Make::className(), ['id' => 'make_id']);
    }
}
