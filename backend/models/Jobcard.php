<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "jobcard".
 *
 * @property int $id
 * @property string $jobcard_number
 * @property string $created_date
 * @property string $promised_date
 * @property double $advance_paid
 * @property string $receipt_num
 * @property int $sales_manager
 * @property int $service_advisor
 * @property double $labour_cost
 * @property double $material_cost
 * @property double $tax
 * @property double $total_charge
 * @property int $customer_id
 */
class Jobcard extends \yii\db\ActiveRecord
{    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobcard';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promised_date', 'advance_paid', 'receipt_num', 'service_manager', 'service_advisor', 'meter_reading', 'fuel_level', 'branch_id'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['advance_paid', 'labour_cost', 'material_cost', 'tax', 'total_charge', 'discount', 'gross_amount', 'amount_due'], 'number'],
            [['service_manager', 'service_advisor', 'customer_id', 'vehicle_id', 'service_type', 'next_service_type', 'tested_by', 'status'], 'integer'],
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
            'created_date' => 'Created Date',
            'promised_date' => 'Promised Date',
            'advance_paid' => 'Advance Paid',
            'receipt_num' => 'Receipt Num',
            'service_manager' => 'Service Manager',
            'service_advisor' => 'Service Advisor',
            'labour_cost' => 'Labour Cost',
            'material_cost' => 'Material Cost',
            'tax' => 'Tax',
            'total_charge' => 'Total Charge',
            'customer_id' => 'Customer ID',
            'vehicle_id' => 'Vehicle ID',
            'branch_id' => 'Branch',
            'tested_by' => 'Vehicle Tested by',
            'status' => 'Jobcard Status'
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'created_date',
                    self::EVENT_BEFORE_UPDATE => 'updated_date',
                ],
                'value' => function() { return date('Y-m-d h:i:s'); // unix timestamp 
                },
            ],
        ];
    }

    public function getBranch(){
        return $this->hasOne(Branches::className(), ['id' => 'branch_id']);
    }

    public function getCustomer(){
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getVehicle(){
        return $this->hasOne(JobcardVehicle::className(), ['id' => 'vehicle_id']);
    }

    public function getMaterials(){
        return $this->hasMany(JobcardMaterial::className(), ['jobcard_id' => 'id']);
    }

    public function getTasks(){
        return $this->hasMany(JobcardTask::className(), ['jobcard_id' => 'id']);
    }

    public function getInvoice(){
        return JobcardInvoice::find()->where(['jobcard_id' => $this->id])->orderBy("id desc")->one();
    }

    public function getLabourCost(){
        if(Yii::$app->common->company->vat_format == "exclusive"){
            return JobcardTask::find()->where(['jobcard_id'=> $this->id])->sum('task_rate');
        }else{
            return JobcardTask::find()->where(['jobcard_id'=> $this->id])->sum('billing_rate');
        }        
    } 

    public function getMaterialCost(){
        if(Yii::$app->common->company->vat_format == "exclusive"){
            return JobcardMaterial::find()->where(['jobcard_id'=> $this->id])->sum('total');
        }else{
            return JobcardMaterial::find()->where(['jobcard_id'=> $this->id])->sum('rate');
        }
    } 
    public static function updateTotals($id){
        $jobcard = static::findOne($id);
        $jobcard->material_cost = $jobcard->materialCost;
        $jobcard->labour_cost = $jobcard->labourCost;
        $gross_amount = $jobcard->materialCost + $jobcard->labourCost;
        $jobcard->gross_amount = $gross_amount;
        if(Yii::$app->common->company->vat_format == "exclusive"){
            $total_charge = $gross_amount - $jobcard->discount;
            $tax = $total_charge*Yii::$app->common->company->vat_rate/100;
            $jobcard->tax = $tax;
            $amount_due = $total_charge+$tax;
        }else{
            $total_charge = $gross_amount;
            $amount_due = $gross_amount;
        }
        $jobcard->total_charge = $total_charge;
        $jobcard->amount_due = $amount_due;
        $jobcard->save();
    }


    public function updateStock(){ 
        
        foreach($this->materials as $material){
            $tot_reduced = 0;
            $tot_added = 0;
            $prev_stock = StockHistory::find()->where(["type" => $material->material_type, 'item_id' => $material->material_id, 'branch_id' => $this->branch_id])->orderBy('id desc')->limit(1)->one();

            $stock = new StockHistory();
            $stock->type = $material->material_type;
            $stock->item_id = $material->material_id;
            $stock->jobcard_id = $this->id;
            $stock->branch_id = $this->branch_id; 
            $stock->previous_stock = $prev_stock->current_stock;
            $stock->date = date("Y-m-d");
            if(StockHistory::find()->where(["type" => $material->material_type, "jobcard_id" => $this->id, 'item_id' => $material->material_id, 'branch_id' => $this->branch_id])->count()){
                // Stock corrections done earlier
                $prev_stocks = StockHistory::find()->where(["type" => $material->material_type, "jobcard_id" => $this->id, 'item_id' => $material->material_id, 'branch_id' => $this->branch_id])->all();
                foreach($prev_stocks as $jc_stock){
                    $tot_reduced += $jc_stock->reduced_stock;
                    $tot_added += $jc_stock->opening_stock;
                }
                $tot_used = $tot_reduced - $tot_added;
                if($material->num_unit > $tot_used){
                    $additional_num = $material->num_unit - $tot_used;
                    $stock->reduced_stock = $additional_num;
                    $stock->opening_stock = 0;
                    $stock->current_stock = ($prev_stock->current_stock - $additional_num);
                }else{
                    $return_stock = $tot_used - $material->num_unit;
                    $stock->opening_stock = $return_stock;
                    $stock->reduced_stock = 0;
                    $stock->current_stock = ($prev_stock->current_stock + $return_stock);
                }
            }else{
                $stock->opening_stock = 0;
                $stock->reduced_stock = $material->num_unit;
                $stock->current_stock = ($prev_stock->current_stock - $material->num_unit);
            }
            if($stock->opening_stock == 0 && $stock->reduced_stock == 0){
                continue;
            }else{            
                $stock->save(); 
            }
        }
        return true;       
    }

    public function updateStockDetails(){
        foreach($this->materials as $material){
            $tot_reduced = 0;
            $tot_added = 0;
            $prev_stock = StockHistory::find()->where(["type" => $material->material_type, 'item_id' => $material->material_id, 'branch_id' => $this->branch_id])->orderBy('id desc')->limit(1)->one();

            $stock = new StockHistory();
            $stock->type = $material->material_type;
            $stock->item_id = $material->material_id;
            $stock->jobcard_id = $this->id;
            $stock->branch_id = $this->branch_id; 
            $stock->previous_stock = $prev_stock->current_stock;
            $stock->date = date("Y-m-d");
            if(StockHistory::find()->where(["type" => $material->material_type, "jobcard_id" => $this->id, 'item_id' => $material->material_id, 'branch_id' => $this->branch_id])->count()){
                // Stock corrections done earlier
                $prev_stocks = StockHistory::find()->where(["type" => $material->material_type, "jobcard_id" => $this->id, 'item_id' => $material->material_id, 'branch_id' => $this->branch_id])->all();
                foreach($prev_stocks as $jc_stock){
                    $tot_reduced += $jc_stock->reduced_stock;
                    $tot_added += $jc_stock->opening_stock;
                }
                $tot_used = $tot_reduced - $tot_added;
                if($material->num_unit > $tot_used){
                    $additional_num = $material->num_unit - $tot_used;
                    $stock->reduced_stock = $additional_num;
                    $stock->opening_stock = 0;
                    $stock->current_stock = ($prev_stock->current_stock - $additional_num);
                }else{
                    $return_stock = $tot_used - $material->num_unit;
                    $stock->opening_stock = $return_stock;
                    $stock->reduced_stock = 0;
                    $stock->current_stock = ($prev_stock->current_stock + $return_stock);
                }
            }else{
                $stock->opening_stock = 0;
                $stock->reduced_stock = $material->num_unit;
                $stock->current_stock = ($prev_stock->current_stock - $material->num_unit);
            }
            if($stock->opening_stock == 0 && $stock->reduced_stock == 0){
                continue;
            }else{            
                if($stock->save()){
                    //Update Stock Distribution
                    //StockDistribution::find()->where(['item_id' => , 'current_stock'])->all()

                    //Updated Stock Distribution
                }
            }
        }
        return true;  
        
    }    
}
