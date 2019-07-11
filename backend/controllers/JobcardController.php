<?php

namespace backend\controllers;

use Yii;
use backend\models\Jobcard;
use backend\models\Customer;
use backend\models\JobcardVehicle;
use backend\models\JobcardVehicleSearch;
use backend\models\JobcardSearch;
use backend\models\CustomerSearch;
use backend\models\JobcardTask;
use backend\models\JobcardMaterial;
use backend\models\JobcardTaskLog;
use backend\models\JobcardInvoice;
use backend\models\JobcardInvoiceMaterial;
use backend\models\JobcardInvoiceTask;
use backend\models\JobcardQuotation;
use backend\models\JobcardQuotationMaterial;
use backend\models\JobcardQuotationTask;
use backend\models\User;
use backend\models\Employees;
use backend\models\TempQuotation;
use backend\models\ItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * JobcardController implements the CRUD actions for Jobcard model.
 */
class JobcardController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Jobcard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobcardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jobcard model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Jobcard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    { 
        $model = new Jobcard();
        $vehicle = new JobcardVehicle();
        $customer = new Customer(); 
        
        if ($model->load(Yii::$app->request->post())) { 
            $model->status = 4;
            if($model->save()){
                if($vehicle->load(Yii::$app->request->post())){
                    if($jc_vehicle = JobcardVehicle::find()->where(["reg_num" => $vehicle->reg_num])->one()){
                        $model->vehicle_id = $jc_vehicle->id;
                    }else{
                        $vehicle->save();
                        $model->vehicle_id = $vehicle->id;
                    }
                }   
                if($customer->load(Yii::$app->request->post())) {
                    if($jc_customer = Customer::find()->where(["email" => $customer->email])->one()){
                      $model->customer_id = $jc_customer->id; 
                    }else{
                        $customer->save();
                        $model->customer_id = $customer->id;
                  }  
                }
                if($model->save()){
                    $model->vehicle->customer_id = $model->customer_id;                
                    $model->vehicle->save();
                    echo json_encode(["success" => true, "message" => "Jobcard has been created", 'redirect' => Yii::$app->getUrlManager()->createUrl(['jobcard/update', 'id' => $model->id])]);
                    exit;
                }
            }            
        }
        return $this->renderAjax('create', [
            'model' => $model,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'activeTab' => 'job-card'
        ]);
    }

    /**
     * Updates an existing Jobcard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $taskId="", $jobcardMatId="", $tab="")
    {
        $model = $this->findModel($id);
        $vehicle = $model->vehicle;
        $customer = $model->customer;
        $activeTab = ($tab)?$tab:'job-card';
        $task_stat = "updated";
        $mat_stat = "updated";

        $taskquery = JobcardTask::find();
        $materialquery = JobcardMaterial::find();
        
        $taskquery->andFilterWhere([
            'jobcard_id' => $model->id,
        ]);
        $taskdataProvider = new ActiveDataProvider([
            'query' => $taskquery,
        ]);

        $materialquery->andFilterWhere([
            'jobcard_id' => $model->id,
        ]);
        $materialdataProvider = new ActiveDataProvider([
            'query' => $materialquery,
        ]);

        if($taskId){ 
            $jobcardTask = JobcardTask::findOne($taskId);
            $activeTab = 'task';
            if($jobcardTask->discount_percent){
                $jobcardTask->discount = "discount_percent";
            }else{
                $jobcardTask->discount = "discount_amount";
            }
        }else{
            $jobcardTask = new JobcardTask(); 
            $jobcardTask->jobcard_id = $model->id;
            $task_stat = "assigned";         
        }

        if ($jobcardTask->load(Yii::$app->request->post())) {
            $jobcardTask->status = ($jobcardTask->status == ""?"queue":$jobcardTask->status);
            $jobcardTask->jobcard_id = $model->id;
            if($jobcardTask->discount == "discount_percent"){
                $jobcardTask->discount_amount = ($jobcardTask->discount_percent)?($jobcardTask->discount_percent*$jobcardTask->task_rate/100):"";
            }else{
                $jobcardTask->discount_percent = "";
            }
            
            if($jobcardTask->save()){             
                $jobcardTask->billable = $jobcardTask->task->billable;
                if($jobcardTask->billable == "yes"){
                    $jobcardTask->task_rate = $jobcardTask->task->billing_rate;
                    //Reduce Discount from Total
                    if($jobcardTask->discount_amount){
                        $price = $jobcardTask->task->billing_rate - $jobcardTask->discount_amount;
                    }else $price = $jobcardTask->task->billing_rate;
                                        
                    $jobcardTask->tax_enabled = ($jobcardTask->task->tax_enabled)?$jobcardTask->task->tax_enabled:'no';
                    $jobcardTask->tax_rate = $jobcardTask->task->tax_rate;  
                    $jobcardTask->tax_amount = ($jobcardTask->task->tax_rate)?($jobcardTask->task->tax_rate *$price/100):""; 
                    //Add Tax to final amount after discount
                    $jobcardTask->billing_rate =  ($jobcardTask->task->tax_enabled =="yes")?($price+($price*$jobcardTask->task->tax_rate/100)):$price;
                }             
                $jobcardTask->save();
                echo json_encode(["success" => true, "message" => 'Task has been '.$task_stat.' to this Jobcard.', 'redirect' => Yii::$app->getUrlManager()->createUrl(['jobcard/update', 'id' => $model->id, 'tab' => 'task'])]);
                exit;                
            } else{ 
                echo json_encode(["error" => true, "message" => implode(", ", $jobcardTask->getErrors('task_id')), 'redirect' => Yii::$app->getUrlManager()->createUrl(['jobcard/update', 'id' => $model->id, 'tab' => 'task'])]);
                    exit;
            }       
            $activeTab = 'task';
        }   

        if($jobcardMatId){ 
            $jobcardMaterial = JobcardMaterial::findOne($jobcardMatId);
            if($jobcardMaterial->discount_percent){
                $jobcardMaterial->discount = "discount_percent";
            }else{
                $jobcardMaterial->discount = "discount_amount";
            }
            $activeTab = 'material';           
        }else{
            $jobcardMaterial = new JobcardMaterial(); 
            $jobcardMaterial->material_type =  'accessories'; 
            $mat_stat = "assigned";
        }
        if ($jobcardMaterial->load(Yii::$app->request->post())) { 
            $jobcardMaterial->jobcard_id = $model->id;
            if($jobcardMaterial->discount == "discount_percent"){
                $jobcardMaterial->discount_amount = ($jobcardMaterial->discount_percent)?($jobcardMaterial->discount_percent*$jobcardMaterial->rate/100):"";
            }else{
                $jobcardMaterial->discount_percent = "";
            }
            if($jobcardMaterial->save()){
                //Reduce Discount from Total
                if($jobcardMaterial->discount_amount){
                    $mat_price = $jobcardMaterial->rate - $jobcardMaterial->discount_amount;
                }else $mat_price = $jobcardMaterial->rate;

                $jobcardMaterial->unit_rate = $jobcardMaterial->material->rate;
                $jobcardMaterial->tax_enabled = ($jobcardMaterial->material->tax_enabled)?$jobcardMaterial->material->tax_enabled:'no';
                $jobcardMaterial->tax_rate = $jobcardMaterial->material->tax_rate;
                $jobcardMaterial->tax_amount = ($jobcardMaterial->material->tax_rate)?($jobcardMaterial->material->tax_rate *$mat_price/100):"";
                if($jobcardMaterial->rate){
                   $jobcardMaterial->total = $jobcardMaterial->rate;
                   
                   //Add Tax to final amount after discount
                    $jobcardMaterial->rate =  ($jobcardMaterial->material->tax_enabled =="yes")?($mat_price+($mat_price*$jobcardMaterial->material->tax_rate/100)):$mat_price;             
                }
                if($jobcardMaterial->save()){               
                    echo json_encode(["success" => true, "message" => 'Material has been '.$mat_stat.' to this Jobcard.', 'redirect' => Yii::$app->getUrlManager()->createUrl(['jobcard/update', 'id' => $model->id, 'tab' => 'material'])]);
                exit; } 
            }else{ 
                echo json_encode(["error" => true, "message" => Yii::$app->common->showModelErrors($jobcardMaterial), 'redirect' => Yii::$app->getUrlManager()->createUrl(['jobcard/update', 'id' => $model->id, 'tab' => 'material'])]);
                    exit;
            }   
            $activeTab = 'material';
        }        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($vehicle->load(Yii::$app->request->post())){
                if($vehicle->save()){
                    if($customer->load(Yii::$app->request->post())) {
                        if($customer->save()){
                            $model->customer_id = $customer->id;
                            $model->vehicle_id = $vehicle->id;
                            $model->save();
                        }   
                    }                    
                }
            } 
            $model->vehicle->customer_id = $model->customer_id;                
            $model->vehicle->save();  

            echo json_encode(["success" => true, "message" => "Jobcard has been updated"]);
            exit;
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'taskdataProvider' => $taskdataProvider,
            'jobcardTask' => $jobcardTask,
            'jobcardMaterial' => $jobcardMaterial,
            'activeTab' => $activeTab,
            'materialdataProvider' => $materialdataProvider
        ]);
    }

    public function actionTask(){
        $post = Yii::$app->request->post();
        $task = JobcardTask::findOne($post['job_taskId']);
        return $this->renderPartial('_taskview',compact('task'));
    }

    /* Mechanic Login */
    public function actionMyTasks(){   
        if(isset(Yii::$app->user->identity->employee)){
            //Change after Permission integration
            if(Yii::$app->user->identity->employee->designation_id == 4){
                $mechanic_id = Yii::$app->user->identity->employee->id;
                $taskquery = JobcardTask::find();
                $taskquery->andFilterWhere([
                    'mechanic_id' => $mechanic_id,
                ]);
                $taskdataProvider = new ActiveDataProvider([
                    'query' => $taskquery,
                ]);
                return $this->render('mytasks', compact('taskdataProvider')); 
            }
        }
        
        Yii::$app->session->setFlash('error', 'You are not allowed to access this page'); 
        return $this->redirect(['index']);
    }


    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewTask($taskId)
    {
        return $this->render('viewTask', [
            'model' => JobcardTask::findOne($taskId),
        ]);
    }

    /**
     * Update Task Status.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTaskStatus($taskId)
    {
        $task = JobcardTask::findOne($taskId);
        $log = new JobcardTaskLog();
        if($task->status == "open"){
            $taskAry = ['inprogress' => 'In Progress'];
        }else if($task->status == "inprogress"){
            $taskAry = ['hold' => 'Hold', 'completed' => 'Completed'];
        }else if($task->status == "hold"){
            $taskAry = ['inprogress' => 'In Progress'];
        }else if($task->status == "reopen"){
            $taskAry = ['inprogress' => 'In Progress'];
        }else if($task->status == "completed"){
            $taskAry = ['inprogress' => 'In Progress'];
        }else{
            Yii::$app->session->setFlash('error', 'Sorry the task may be either closed or not opened.');
            return $this->redirect(['mytasks']);
        }
        if ($log->load(Yii::$app->request->post())) {
            $log->date = date("Y-m-d h:i:s");
            //Save total time for task
            if(in_array($log->status, ["hold", "completed"])){
                $date_from =  date_create(JobcardTaskLog::find()->where(["jobcard_task_id" => $task->id])->orderBy("id desc")->one()->date);
                $date_to = date_create($log->date);
                $date_diff = date_diff($date_from,$date_to);
                $task->total_time += (((($date_diff->d*24)+$date_diff->h)*60)+$date_diff->i);
            }         
            $log->jobcard_task_id = $task->id;
            $log->mechanic_id = Yii::$app->user->id;
            $log->date = date("Y-m-d h:i:s");
            $log->save();
            $task->status = $log->status;
            $task->save();
            Yii::$app->session->setFlash('success', 'Task has been updated.');
            return $this->redirect(['task-status', 'taskId' => $taskId]);
        }
        return $this->render('task-status', [
            'taskAry' => $taskAry,
            'log' => $log,
            'task' => $task,
            'status_colors' => ["open" => "red", "inprogress" => "orange", "hold" => "yellow", "completed" => "green"]
        ]);
    }

    public function actionTaskLog(){
        $post = Yii::$app->request->post();      
        $taskquery = JobcardTaskLog::find();
        $taskquery->andFilterWhere([
            'jobcard_task_id' => $post['job_taskId'],
        ]);
        $taskdlogdataProvider = new ActiveDataProvider([
            'query' => $taskquery,
        ]);
        return $this->renderPartial('_tasklogview',compact('taskdlogdataProvider'));
    }

    /**
     * Deletes an existing Jobcard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteTask($task_id)
    {
        $job_card_task = JobcardTask::findOne($task_id);
        $jc_id = $job_card_task->jobcard_id;
        $job_card_task->delete();
        JobcardTaskLog::deleteAll(['jobcard_task_id' => $task_id]);
        Yii::$app->session->setFlash('success', 'Task has been deleted.');
        return $this->redirect(['update', 'id' => $jc_id]);
    }

    public function actionDeleteMaterial($material_id)
    {
        $job_card_material = JobcardMaterial::findOne($material_id);
        $jc_id = $job_card_material->jobcard_id;
        $job_card_material->delete();
        //Pending reverse material qty to stock after delete --to do
        Yii::$app->session->setFlash('success', 'Material has been deleted.');
        return $this->redirect(['update', 'id' => $jc_id]);
    }

    public function actionApplyDiscount(){
        $post = Yii::$app->request->post();   
        if(isset($post['jobcard_id'])){
            $model = $this->findModel($post['jobcard_id']);
            $model->labour_cost = $model->labourCost;
            $model->material_cost = $model->materialCost;
            $gross_amount = $model->labourCost + $model->materialCost;
            $model->gross_amount = $gross_amount;

            if(isset($post['discount_amount']) || isset($post['discount_percent'])){   
                if(isset($post['discount_amount'])){    
                    $discount = $post['discount_amount'];                   
                }else if(isset($post['discount_percent'])){
                    $discount = $gross_amount*$post['discount_percent']/100;                    
                }
                $model->discount = $discount;
                $total_charge = $gross_amount - $discount;
                $model->total_charge = $total_charge;
                $vat = $total_charge*Yii::$app->common->company->vat_rate/100;
                $model->tax = $vat;
                $model->amount_due = $total_charge + $vat; 
                $model->save();
                echo json_encode(["success" => true, "message" => "Discount Applied", 'redirect' => Yii::$app->getUrlManager()->createUrl(['jobcard/update', 'id' => $model->id, 'tab' => 'total'])]);
                exit;               
            } 
        }
    }

    public function actionInvoice($invoice_id){
        $invoice = JobcardInvoice::findOne($invoice_id);

        $taskquery = JobcardInvoiceTask::find();
        $materialquery = JobcardInvoiceMaterial::find();
        $taskquery->andFilterWhere([
            'invoice_id' => $invoice->id,
        ]);
        $taskdataProvider = new ActiveDataProvider([
            'query' => $taskquery,
            'sort' => false
        ]);

        $materialquery->andFilterWhere([
            'invoice_id' => $invoice->id,
        ]);
        $materialdataProvider = new ActiveDataProvider([
            'query' => $materialquery,
            'sort' => false
        ]);       
        return $this->renderAjax('_invoice',compact('invoice', 'taskdataProvider', 'materialdataProvider'));
    }

    public function actionPrint($jobcard_id){

        $jobcard = $this->findModel($jobcard_id);
        $date = explode(" ", $jobcard->promised_date); 
        $delv_date = explode("/", $date[0]); 
        $jobcard->promised_date = implode("-", array_reverse($delv_date));
        $jobcard->delivrey_time = (isset($date[1]))?$date[1].$date[2]:"Not Set";

        return $this->renderAjax('_print',compact('jobcard'));
    }

    public function actionGenerateInvoice($jobcard_id){
        $jobcard = $this->findModel($jobcard_id);
        $invoice = new JobcardInvoice();
        $invoice->setAttributes($jobcard->getAttributes());
        $invoice->jobcard_id = $jobcard->id;
        $invoice->created_date = date('Y-m-d h:i:s');      
        if($invoice->save()){
            $jobcard->updateStockDetails();
            //Save Invoice Materials -same as Jobcard Materials
            foreach($jobcard->materials as $material){
                $invoice_material = new JobcardInvoiceMaterial();
                $invoice_material->setAttributes($material->getAttributes());
                $invoice_material->invoice_id = $invoice->id;
                $invoice_material->save();
            }

            //Save Invoice Tasks -same as Jobcard Tasks
            foreach($jobcard->tasks as $task){
                $invoice_task = new JobcardInvoiceTask();
                $invoice_task->setAttributes($task->getAttributes());
                $invoice_task->invoice_id = $invoice->id;
                $invoice_task->save();               
            }
            Yii::$app->session->setFlash('success', 'Invoice has been generated.');
            return $this->redirect(['invoice', 'invoice_id' => $invoice->id]);
        }//else{echo "nops";print_r($invoice->getErrors());exit;}
    }

    //quotation
    public function actionGenerateQuotation($jobcard_id){
        $jobcard = $this->findModel($jobcard_id);
        $quotation = new JobcardQuotation();
        $quotation->setAttributes($jobcard->getAttributes());
        $quotation->jobcard_id = $jobcard->id;
        $quotation->created_date = date('Y-m-d h:i:s');     
        // var_dump($quotation->getAttributes());die; 
        if($quotation->save()){
            // $jobcard->updateStockDetails();
            //Save quotation Materials -same as Jobcard Materials
            foreach($jobcard->materials as $material){
                $quotation_material = new JobcardQuotationMaterial();
                $quotation_material->setAttributes($material->getAttributes());
                $quotation_material->quotation_id = $quotation->id;
                $quotation_material->save();
            }
            //Save quotation Tasks -same as Jobcard Tasks
            foreach($jobcard->tasks as $task){
                $quotation_task = new JobcardQuotationTask();
                $quotation_task->setAttributes($task->getAttributes());
                $quotation_task->quotation_id = $quotation->id;
                $quotation_task->save();
            }
            Yii::$app->session->setFlash('success', 'Quotation has been generated.');
            return $this->redirect(['quotation', 'quotation_id' => $quotation->id]);
        }//else{echo "nops";print_r($invoice->getErrors());exit;}
    }

    public function actionQuotation($quotation_id){
        $quotation = JobcardQuotation::findOne($quotation_id);

        $taskquery = JobcardQuotationTask::find();
        $materialquery = JobcardQuotationMaterial::find();
        
        $taskquery->andFilterWhere([
            'quotation_id' => $quotation->id,
        ]);
        $taskdataProvider = new ActiveDataProvider([
            'query' => $taskquery,
            'sort' => false
        ]);

        $materialquery->andFilterWhere([
            'quotation_id' => $quotation->id,
        ]);
        $materialdataProvider = new ActiveDataProvider([
            'query' => $materialquery,
            'sort' => false
        ]);       
        return $this->renderAjax('_quotation',compact('quotation', 'taskdataProvider', 'materialdataProvider'));
    }

    public function actionTempQuotation($jobcard_id){

        $jobcard = $this->findModel($jobcard_id); 
        $quotation = TempQuotation::find()->where(['jobcard_id' => $jobcard_id])->one();
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            if($quotation) $tempQuotation = $quotation;
            else $tempQuotation = new TempQuotation();
            $tempQuotation->jobcard_id = $jobcard_id;
            $tempQuotation->task = $post['tasks'];
            $tempQuotation->material = $post['materials'];
            $tempQuotation->date = date("Y-m-d h:i:s");
            $tempQuotation->created_by = Yii::$app->user->id;
            $tempQuotation->save();
        }       
        if($quotation){
            $tasks = json_decode($quotation->task);
            $materials = json_decode($quotation->material); 
        }else{
            $tasks = [];
            $materials = [];
        }
        
        return $this->renderAjax('_temp_quotation',compact('jobcard', 'tasks', 'materials'));
    }

    public function actionTest(){

        

    }
     /**
     * Displays vehicle list.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSearchVehicle()
    {
        $post = Yii::$app->request->post();       
        $searchModel = new JobcardVehicleSearch();  
        if(isset($post['reg_num'])){
            $searchModel->reg_num = $post['reg_num'];
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->renderAjax('_searchvehicle', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays item list.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSearchItem()
    {
        $post = Yii::$app->request->post(); 
        $page_id = "jobcard-materialssearch".time();      
        $searchModel = new ItemsSearch();  
        if(isset($post['item_name'])){
            $searchModel->item_name = $post['item_name'];
        }
        if(isset($post['item_type'])){
            $searchModel->type = $post['item_type'];
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->renderAjax('_searchitem', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'page_id' => $page_id
        ]);
    }

    /**
     * Displays customer list.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSearchCustomer()
    {
        $post = Yii::$app->request->post();       
        $searchModel = new CustomerSearch();  
        if(isset($post['cus_name'])){
            $searchModel->name = $post['cus_name'];
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->renderAjax('_searchcustomer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVehicleInfo($vehicle_id){
        $vehicle = JobcardVehicle::findOne($vehicle_id);//print_r($vehicle);exit;
        if($vehicle){
            echo json_encode(['jobcardvehicle-reg_num' => $vehicle->reg_num, 'jobcardvehicle-chasis_num' => $vehicle->chasis_num, 'jobcardvehicle-lpo_num' => $vehicle->lpo_num, 'jobcardvehicle-vin' => $vehicle->vin, 'jobcardvehicle-wo_num' => $vehicle->wo_num, 'jobcardvehicle-make_id' => $vehicle->make_id, 'jobcardvehicle-model_id' => $vehicle->model_id, 'jobcardvehicle-color' => $vehicle->color, 'customer-name' => ($vehicle->customer)?$vehicle->customer->name:"", 'customer-contact_number' => ($vehicle->customer)?$vehicle->customer->contact_number:"", 'jobcardvehicle-vehicle_type' => $vehicle->vehicle_type]);
            exit;
        }
    }

    public function actionCustomerInfo($customer_id){
        $customer = Customer::findOne($customer_id);
        if($customer){
            echo json_encode(['customer-name' => $customer->name, 'customer-contact_name' => $customer->contact_name, 'customer-contact_number' => $customer->contact_number, 'customer-alt_phone' => $customer->alt_phone, 'customer-email' => $customer->email, 'customer-address'  => $customer->address]);
            exit;
        }
    }

    public function actionBranchusers($branch_id){
        $service_advisor_data = ""; 
        $service_manager_data = "";
        $tester_data = "";   

        $service_advisors = Employees::find()->where(["status" => 1, "designation_id" => 2, "branch_id" => $branch_id])->all();
        if($service_advisors){
            $service_advisor_data .= '<option value="">Service Advisor</option>';
            foreach($service_advisors as $service_advisor){
                $service_advisor_data .=  '<option value="'.$service_advisor->id.'">'.$service_advisor->fullname.'</option>';
            }
        }

        $service_managers = Employees::find()->where(["status" => 1, "designation_id" => 1, "branch_id" => $branch_id])->all();
        if($service_managers){
            $service_manager_data .= '<option value="">Service Manager</option>';
            foreach($service_managers as $service_manager){
                $service_manager_data .=  '<option value="'.$service_manager->id.'">'.$service_manager->fullname.'</option>';
            }
        }

        $testers = Employees::find()->where(["status" => 1, "designation_id" => 3, "branch_id" => $branch_id])->all();
        if($testers){
            $tester_data .= '<option value="">Vehicle Tested By</option>';
            foreach($testers as $tester){
                $tester_data .=  '<option value="'.$tester->id.'">'.$tester->fullname.'</option>';
            }
        }

        echo json_encode(["service_advisors" => $service_advisor_data, "service_managers" => $service_manager_data, "testers" => $tester_data]);exit;
    }

    /**
     * Approval of Jobcards in Queue
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionApproval(){


        $pending_jobcards = Jobcard::find()->where(["status" => 4])->all();

        return $this->renderAjax('_approval', [
            'pending_jobcards' => $pending_jobcards,
        ]);

    }


    /**
     * Finds the Jobcard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jobcard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jobcard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
