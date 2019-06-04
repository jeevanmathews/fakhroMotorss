<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "branch_types".
 *
 * @property int $id
 * @property string $type
 * @property int $status
 * @property string $created_date
 */
class Branchtypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['status'], 'integer'],
            [['created_date'], 'safe'],
            [['type'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'status' => 'Status',
            'created_date' => 'Created Date',
        ];
    }
     public function getBranches()
        {
            return $this->hasMany(Branches::className(), ['branchtype_id' => 'id']);
        }
}
