<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prefix_master".
 *
 * @property int $id
 * @property string $prefix
 * @property int $branch_id
 * @property string $process
 * @property string $description
 * @property string $created_date
 * @property int $status
 */
class PrefixMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prefix_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix'], 'required'],
            [['process', 'description'], 'string'],
            [['created_date'], 'safe'],
            [['status'], 'integer'],
            [['prefix'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prefix' => 'Prefix',
            'process' => 'Process',
            'description' => 'Description',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
      public function getPrprefix()
    {
        return $this->hasOne(Purchaserequest::className(), ['prefix_id' => 'id']);
    }
     public function getPoprefix()
    {
        return $this->hasOne(Purchaseorder::className(), ['prefix_id' => 'id']);
    }
}
