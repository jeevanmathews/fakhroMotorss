<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $phone_code
 * @property int $status
 * @property string $created_at
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['name'], 'required'],
            [['code'], 'string', 'max' => 100],
            [['phone_code'], 'string', 'max' => 50],
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
            'code' => 'Code',
            'phone_code' => 'Phone Code',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
     public function getBranch()
        {
            return $this->hasOne(Branches::className(), ['country_id' => 'id']);
        }
}
