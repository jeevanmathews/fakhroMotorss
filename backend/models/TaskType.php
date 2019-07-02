<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "task_type".
 *
 * @property int $id
 * @property string $task_type
 * @property int $status
 */
class TaskType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_type'], 'required'],
            [['status'], 'integer'],
            [['task_type', 'vehicle_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_type' => 'Task Type',
            'status' => 'Status',
        ];
    }
}
