<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "temp_quotation".
 *
 * @property int $id
 * @property int $jobcard_id
 * @property string $task
 * @property string $material
 * @property string $date
 * @property int $created_by
 */
class TempQuotation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temp_quotation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jobcard_id', 'task', 'material', 'date', 'created_by'], 'required'],
            [['jobcard_id', 'created_by'], 'integer'],
            [['task', 'material'], 'string'],
            [['date'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jobcard_id' => 'Jobcard ID',
            'task' => 'Task',
            'material' => 'Material',
            'date' => 'Date',
            'created_by' => 'Created By',
        ];
    }
}
