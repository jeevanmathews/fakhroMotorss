<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jobcard_task".
 *
 * @property int $id
 * @property string $task
 * @property string $start_date_time
 * @property string $end_date_time
 * @property string $total_time
 * @property string $billable
 * @property double $billing_rate
 */
class JobcardTask extends \yii\db\ActiveRecord
{
    public $discount;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobcard_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],  
             [['note'], 'string'],       
            [['task_id', 'mechanic_id', 'jobcard_id'], 'integer'],
            ['task_id', 'unique', 'targetAttribute' => ['task_id', 'jobcard_id']],
            [['billing_rate', 'total_time', 'tax_rate', 'tax_amount', 'discount_percent', 'discount_amount'], 'number'],
            [['start_date_time', 'end_date_time', 'billable', 'discount', 'status'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task',
            'jobcard_id' => 'Jobcard Number',
            'start_date_time' => 'Expected Start Date',
            'end_date_time' => 'Expected End Date',
            'total_time' => 'Logged Time',           
            'billing_rate' => 'Total',
            'mechanic_id' => 'Mechanic',
            'tax_rate' => 'Tax Rate (%)',
            'task_rate' => 'Price'
        ];
    }

    public function getTask(){
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
    public function getLogs(){
        return $this->hasMany(JobcardTaskLog::className(), ['id' => 'task_id']);
    }    
    public function getMechanic(){
        return $this->hasOne(Employees::className(), ['id' => 'mechanic_id']);
    }
    public function afterSave($insert, $changedAttributes)
    {
         parent::afterSave($insert, $changedAttributes);
         Jobcard::updateTotals($this->jobcard_id);
    }
}
