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

    public function assignTask($jobcard_id){
        $jobcardTask = new JobcardTask(); 
        $jobcardTask->jobcard_id = $jobcard_id;
        $jobcardTask->task_id = $this->id;
        $jobcardTask->note = "";
        $jobcardTask->status = "queue";
        $jobcardTask->billable = $this->billable;
        if($this->billable == "yes"){
            $jobcardTask->task_rate = $this->billing_rate;
            $price = $jobcardTask->task->billing_rate;
            $jobcardTask->tax_enabled = $this->tax_enabled;
            $jobcardTask->tax_rate = $this->tax_rate;  
            $jobcardTask->tax_amount = ($this->tax_rate)?($this->tax_rate *$price/100):""; 
            //Add Tax to final amount after discount
            $jobcardTask->billing_rate =  ($this->tax_enabled =="yes")?($price+($price*$this->tax_rate/100)):$price;
        }
        return ($jobcardTask->save())?$jobcardTask->id:""; 
    }

    public function getNamewithPrice(){
        return ($this->billable == "yes")?($this->task." - ".Yii::$app->common->company->settings->currency->code. " " .$this->billing_rate):$this->task;
    }
}
