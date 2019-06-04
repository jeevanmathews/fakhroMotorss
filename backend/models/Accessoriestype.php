<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "accessories_type".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class Accessoriestype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accessories_type';
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
     public function getAccessories()
        {
            return $this->hasOne(Accessories::className(), ['accessories_type_id' => 'id']);
        }
}
