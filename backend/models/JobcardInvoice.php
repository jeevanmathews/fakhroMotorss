<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jobcard_invoice".
 *
 * @property int $id
 * @property int $jobcard_id
 * @property int $customer_id
 * @property int $vehicle_id
 * @property int $meter_reading
 * @property int $fuel_level
 * @property string $promised_date
 * @property double $advance_paid
 * @property string $receipt_num
 * @property int $service_manager
 * @property int $service_advisor
 * @property int $service_type
 * @property int $next_service_type
 * @property int $tested_by
 * @property string $comment
 * @property double $labour_cost
 * @property double $material_cost
 * @property double $gross_amount
 * @property double $discount
 * @property double $total_charge
 * @property double $tax
 * @property double $amount_due
 * @property string $created_date
 * @property string $updated_date
 * @property int $status
 */
class JobcardInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobcard_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jobcard_id', 'meter_reading', 'fuel_level', 'promised_date', 'created_date'], 'required'],
            [['jobcard_id', 'customer_id', 'vehicle_id', 'meter_reading', 'fuel_level', 'service_manager', 'service_advisor', 'service_type', 'next_service_type', 'tested_by', 'status'], 'integer'],
            [['advance_paid', 'labour_cost', 'material_cost', 'gross_amount', 'discount', 'total_charge', 'tax', 'amount_due'], 'number'],
            [['comment'], 'string'],
            [['created_date'], 'safe'],
            [['promised_date', 'receipt_num'], 'string', 'max' => 300],
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
            'customer_id' => 'Customer ID',
            'vehicle_id' => 'Vehicle ID',
            'meter_reading' => 'Meter Reading',
            'fuel_level' => 'Fuel Level',
            'promised_date' => 'Promised Date',
            'advance_paid' => 'Advance Paid',
            'receipt_num' => 'Receipt Num',
            'service_manager' => 'Service Manager',
            'service_advisor' => 'Service Advisor',
            'service_type' => 'Service Type',
            'next_service_type' => 'Next Service Type',
            'tested_by' => 'Tested By',
            'comment' => 'Comment',
            'labour_cost' => 'Labour Cost',
            'material_cost' => 'Material Cost',
            'gross_amount' => 'Gross Amount',
            'discount' => 'Discount',
            'total_charge' => 'Total Charge',
            'tax' => 'Tax',
            'amount_due' => 'Amount Due',
            'created_date' => 'Created Date',          
            'status' => 'Status',
        ];
    }

    public function getCustomer(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getVehicle(){
        return $this->hasOne(JobcardVehicle::className(), ['id' => 'vehicle_id']);
    }

    public function getJobcard(){
        return $this->hasOne(Jobcard::className(), ['id' => 'jobcard_id']);
    }
	public function getAdvisor(){
	   return $this->hasOne(Employees::className(), ['id' => 'service_advisor']);
	   
	}

	public function getManager(){
	   return $this->hasOne(Employees::className(), ['id' => 'service_manager']);
	   
	}
	public function getTestedby(){
	   return $this->hasOne(Employees::className(), ['id' => 'tested_by']);
	   
	}
	public function getServiceType(){
	   return $this->hasOne(ServiceType::className(), ['id' => 'service_type']);
	   
	}
	public function getNextServiceType(){
	   return $this->hasOne(ServiceType::className(), ['id' => 'service_type']);
	   
	}
	public function getJobcardStatus(){
	   return $this->hasOne(JobcardStatus::className(), ['id' => 'status']);
	   
	}
}
