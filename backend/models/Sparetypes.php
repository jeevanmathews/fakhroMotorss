<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "spare_types".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class Sparetypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'spare_types';
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
     public function getSpares()
        {
            return $this->hasOne(Spareparts::className(), ['spare_type_id' => 'id']);
        }
}
