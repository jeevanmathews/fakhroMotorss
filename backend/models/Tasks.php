<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $task
 * @property string $description
 * @property int $billable
 * @property string $total_time
 * @property string $actual_rate
 * @property string $billing_rate
 * @property string $type
 * @property string $created_date
 * @property int $status
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task', 'description','type'], 'required'],
            [['description', 'type','tax_enabled'], 'string'],
            [['status'], 'integer'],
            [['actual_rate', 'billing_rate','tax_rate'], 'number'],
            [['created_date'], 'safe'],
            [['task'], 'string', 'max' => 250],
          
            [['actual_rate', 'billing_rate', 'billable'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task' => 'Task',
            'description' => 'Description',
            'billable' => 'Billable',
           // 'total_time' => 'Allowed Time',
            'actual_rate' => 'Actual Rate',
            'billing_rate' => 'Billing Rate',
            'type' => 'Type',
            'created_date' => 'Created Date',
			'tax_enabled' => 'Tax Enabled',
			'tax_rate'=> 'Tax Rate',
			'status' => 'Status',
        ];
    }

    public function getNamewithPrice(){
        return ($this->billable == "yes")?($this->task." - ".Yii::$app->common->company->settings->currency->code. " " .$this->billing_rate):$this->task;
    }
}
