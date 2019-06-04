<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jobcard_task_log".
 *
 * @property int $id
 * @property int $mechanic_id
 * @property string $status
 * @property string $comment
 * @property string $date
 */
class JobcardTaskLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobcard_task_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mechanic_id', 'status', 'date'], 'required'],
            [['mechanic_id', 'jobcard_task_id'], 'integer'],
            [['status', 'comment'], 'string'],
            [['date'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mechanic_id' => 'Mechanic ID',
            'status' => 'Status',
            'comment' => 'Comment',
            'date' => 'Date',
        ];
    }

    public function getJctask(){
        return $this->hasOne(JobcardTask::className(), ['id' => 'jobcard_task_id']);
    }
}
