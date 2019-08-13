<?php

namespace common\components;

use Yii;
use yii\base\Component;

use backend\models\CompanySettings;
use backend\models\SignupForm;
use backend\models\Company;
use backend\models\PrefixMaster;
use backend\models\User;
use backend\models\UserRole;
use backend\models\Roles;
use backend\models\Log;
use yii\helpers\Html;
use yii\imagine\Image;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Common extends Component
{
    public static $api_key = "fabc0aee-2967-11e7-929b-00163ef91450";
     /**
     * Validate server rules from ajax request
     * @param post data
     * @return validation result
     */
    public function validateEntry($post){
      
      if($post["modelName"] == "user"){
          $model =($post["mid"])?User::findOne($post["mid"]):new User;
      }    
      if($post["modelName"] == "SignupForm"){
          $model = new SignupForm;
      }
      $model->{$post["fieldName"]} = $post["fieldValue"]; 
      if($post["scenario"])
        $model->setscenario($post["scenario"]); 
      
      if( $model->validate()){
          return true;
      }else{  
        if(isset($model->getErrors()[$post["fieldName"]][0]))       
           return $model->getErrors()[$post["fieldName"]][0];
       else
        return true;
      }
    }
    
	 /**
     * Validate server rules from ajax request
     * @param post data
     * @return validation result
     */
    public function displayDate($date){
      $dateformat= CompanySettings::find()->select(['date_format'])->where(['company_id' => 1])->one();   
      return date($dateformat->date_format,strtotime($date));
    }

    public function displayEndDate($date){
       $dateformat= CompanySettings::find()->select(['date_format'])->where(['company_id' => 1])->one();
       $newdate= date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " + 1 year"));
       $final=date("Y-m-d", strtotime(date("Y-m-d", strtotime($newdate)) . " - 1 day"));
       return  date($dateformat->date_format,strtotime($final));
    }

    public function randomName($length = 5){
      return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)))), 1, $length);
    }

    public function getCompany(){
      $company = Company::findOne(1);
      return $company;
    }

    public function getBranchid(){ 
      $branch_id = User::find()->where(['id'=>\Yii::$app->user->identity->id])->select(['branch_id'])->one();
      return $branch_id;
    }

    public function getTimedisplay($seconds){
      $dtF = new \DateTime('@0');
      $dtT = new \DateTime("@$seconds");
      return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
    }

    public function number_format($number){
      return round($number, 3);
    }
    public function getDecimalplaces(){
      $company = Company::findOne(1);
      return $company->settings->decimal_places;
    }

    public function getPrefix(){
     $process=Yii::$app->controller->id;
     $company = PrefixMaster::find()->select(['id'])->where(['process'=> $process,'status'=>1])->one();//,'branch_id'=>Yii::$app->user->identity->branch_id
     return $company;
    }

    public function listViewActions($controller){
      if($controller == "jobcard"){
        if(Yii::$app->user->identity->employee){
          //Change after Permission integration
          if(Yii::$app->user->identity->employee->designation_id == 4)
            return "{mytasks}";
        }
        return "{view}{update}"; 
      }
    }

    public function buildTree(array $elements, $parentId = 0, $call="") {
      $branch = array();
      $idtag = ($parentId == 0 && $call == 1) ? 'id="tree2'.time().'"' : "";;
      echo "<ul $idtag>";
      foreach ($elements as $element) {       
          if ($element['parent'] == $parentId) {
            echo '<li><a href="#">'.$element['category_name'].'</a>';
              $children = $this->buildTree($elements, $element['id']);
              echo "</li>";
              if ($children) {              
                  $element['children'] = $children;               
              }
              $branch[] = $element;
          }
      }
      echo "</ul>";
      return $branch;
    }

    public function showModelErrors($model, $attributes=[]){
      $error = [];
      foreach ($model->getErrors() as $attribute => $errors) {
        if($attributes){
          if(!in_array($attribute, $attributes)){
            continue;
          }
        }
        $error[] = implode(", ", $errors);
      }
      return ($error)?(implode("</br>", $error)):"";
    }

    public function setUserPermissions(){
      $session = Yii::$app->session;
      $roles = UserRole::find()->where(["user_id" => Yii::$app->user->id])->all();
      $permissions = [];
      foreach ($roles as $role) {
        $role = Roles::findOne($role->role_id);
        foreach ($role->permissions as $role_permission) {       
          if(array_key_exists($role_permission->permissionmaster->module, $permissions)){
            $permission_actions = $permissions[$role_permission->permissionmaster->module];           
            if(!in_array($role_permission->permissionmaster->action, $permission_actions)){
              $permission_actions[] = $role_permission->permissionmaster->action;
            }            
          }else{
            $permission_actions = [];
            $permission_actions[] = $role_permission->permissionmaster->action;            
          }
          $permissions[$role_permission->permissionmaster->module] = $permission_actions;
        }
      }
      $session->set('permissions', $permissions);  
    }

    public function checkPermission($controller, $action, $return="page"){

      // Log the action
      if($return == "page"){
        $log = new Log();
        $log->controller = $controller;
        $log->action = $action;
        $log->query_string = $_SERVER['QUERY_STRING'];
        $log->loggedin_user = Yii::$app->user->id; 
        $log->save();
      }      

      $permissions =  Yii::$app->session->get('permissions');
      $action =  str_replace("-", "", $action);
      if($permissions){
        if(array_key_exists($controller, $permissions)){
          $controller_permission = $permissions[$controller];
          if(in_array($action, $controller_permission)){
            return true;
          }
        }
      }if($return == "page"){
        echo 404;
        exit; 
      }else{
        return false;
      }      
    }

    public function getMenu(){
      // Logged in user permissions
      $permissions =  Yii::$app->session->get('permissions');



      /* Check if user has Master Permission*/
      $masters_menus = [     
        "CurrencyController" => ['Currency',  '/currency/index'],
        "UnitsController" => ['Units',  '/units/index'],
        "SupplierController" => ['Supplier',  '/supplier/index'],
        "SupplierGroupController" => ['Supplier Groups',  '/suppliergroup/index'],
        "BranchtypesController" => ['Branch Types',  '/branchtypes/index'],       
        "AmcTypeController" => ['Amc Types',  '/amc-type/index'],
        "ExtendedWarrantyTypeController" => ['Extended Warranty Types',  '/extended-warranty-type/index'],
        "ServiceTypeController" => ['Service Type',  '/service-type/index'],
        "PrefixMasterController" => ['Prefix',  '/prefix-master/index'],
        'LogController' => ['Log', '/log/index'],
      ];
      $mater_str = '';
      foreach($masters_menus as $masters_menu => $item){
        if(isset($permissions[$masters_menu])){        
          $permission_data = $permissions[$masters_menu];
          if(in_array("index", $permission_data)){       
            $mater_str .= '<li>'.Html::a($item[0], [$item[1]], ['class'=>'']).'</li>';
          }
        }
      }
      if($mater_str){
        echo '<li class="dropdown"><a href="#">Masters</a><ul class="dropdown-menu">'.$mater_str.'</ul></li>';
      }

      /* Check if user has Administration Permission*/
      $administration_menus = [
        "DepartmentsController" => ['Departments',  '/departments/index'],
        "DesignationsController" => ['Designations',  '/designations/index'],
        "RolesController" => ['Roles',  '/roles/index'],
        "EmployeesController" => ['Staff',  '/employees/index'],
      ];
      $admstr_str = '';
      foreach($administration_menus as $administration_menu => $aditem){
        if(isset($permissions[$administration_menu])){         
          $permission_data = $permissions[$administration_menu];
          if(in_array("index", $permission_data)){        
            $admstr_str .= '<li>'.Html::a($aditem[0], [$aditem[1]], ['class'=>'']).'</li>';
          }
        }
      }
      if($admstr_str){
        echo '<li class="dropdown"><a href="#">Administration</a><ul class="dropdown-menu">'.$admstr_str.'</ul></li>';
      }

       /* Check if user has Inventory Permission*/
      $inventory_menus = [
        "VehicletypeController" => ['Vehicle Type',  '/vehicletype/index'],
        "VehiclemodelsController" => ['Vehicle',  '/vehiclemodels/index'],
        "ItemsController" => ['Items', '/items/index'],
        "ItemgroupController" => ['Accessories', '/itemgroup/index'],
        "ItemgroupController" => ['Spare Parts', '/itemgroup/index','type' => 'spares'],
      ];
      $invtry_str = '';
      foreach($inventory_menus as $inventory_menu => $initem){
        if(isset($permissions[$inventory_menu])){         
          $permission_data = $permissions[$inventory_menu];
          if(in_array("index", $permission_data)){          
            $invtry_str .= '<li>'.Html::a($initem[0], [$initem[1]], ['class'=>'']).'</li>';
          }
        }
      }
      if($invtry_str){
        $invtry_str = '<li><h4>Products</h4></li>'.$invtry_str;
      }

      // Service in inventory
      $services_menus = [
        "TasksController" => ['Service Tasks', '/tasks/index'],
        "TaskTypeController" => ['Task Types', '/tasktype/index'],
      ];
      $serv_str = '';
      foreach($services_menus as $services_menu => $servitem){
        if(isset($permissions[$services_menu])){         
          $permission_data = $permissions[$services_menu];
          if(in_array("index", $permission_data)){        
            $serv_str .= '<li>'.Html::a($servitem[0], [$servitem[1]], ['class'=>'']).'</li>';
          }
        }
      }
      if($serv_str){
        $serv_str = '<li><h4>Services</h4>'.$serv_str;
      }
      if($invtry_str || $serv_str){ echo '<li class="dropdown"><a href="#">Inventory</a><ul class="dropdown-menu">'.$invtry_str.$serv_str.'</ul></li>';}

      /* Check if user has Purchase Permission*/
      $purchase_menus = [
       "PurchaseRequestController" => ['Purchase Requisition', '/purchase-request/index'],
       "PurchaseOrderController" => ['Purchase Order', '/purchase-order/index'],
       "GoodsReceiptNoteController" => ['GRN', '/goods-receipt-note/index'],
       "PurchaseInvoiceController" => ['Purchase Invoice', '/purchase-invoice/index'],
       "PurchaseReturnController" => ['Purchase return', '/purchase-return/index'],
      ];

      $purchas_str = '';
      foreach($purchase_menus as $purchase_menu => $purchasitem){
        if(isset($permissions[$purchase_menu])){         
          $permission_data = $permissions[$purchase_menu];
          if(in_array("index", $permission_data)){     
            $purchas_str .= '<li>'.Html::a($purchasitem[0], [$purchasitem[1]], ['class'=>'']).'</li>';
          }
        }
      }
      if($purchas_str){
        echo '<li class="dropdown"><a href="#">Purchase</a><ul class="dropdown-menu">'.$purchas_str.'</ul></li>';
      }

      /* Check if user has Jobcard Permission*/
      $jobcard_menus = [
        "JobcardController" => ['Jobcard', '/jobcard/index'],
        "JobcardVehicleController" => ['Jobcard Vehicle', '/jobcard-vehicle'],
        "ManufacturerController" => ['Manufacturer', '/manufacturer/index'],
        "CarModelController" => ['Model', '/car-model'],
        "CustomerController" => ['Customer', '/customer/index'],
        "JobcardApController" => ['Jobcard Approval', '/jobcard/approval'],
      ];
      $jc_str = '';
      foreach($jobcard_menus as $jobcard_menu => $jcitem){
        $menu = "";
        if( $jobcard_menu == "JobcardApController") {$jobcard_menu = "JobcardController"; $menu = "approval";}
        if(isset($permissions[$jobcard_menu])){ 
          $permission_data = $permissions[$jobcard_menu];
          if($menu){
            if(in_array("approval", $permission_data)){
              $jc_str .= '<li>'.Html::a($jcitem[0], [$jcitem[1]], ['class'=>'']).'</li>';
            }
          } else if(in_array("index", $permission_data)){  
            $jc_str .= '<li>'.Html::a($jcitem[0], [$jcitem[1]], ['class'=>'']).'</li>';
          }
        }
      }
      if($jc_str){
        echo '<li class="dropdown"><a href="#">Jobcard</a><ul class="dropdown-menu">'.$jc_str.'</ul></li>';
      }

      /* Check if user has Sales Permission*/
      $sales_menus = [
        "QuotationController" => [ 'Quotation', '/quotation/index' ],
        "SalesOrderController" => [ 'Sales Order', '/sales-order/index' ],
        "DeliveryOrderController" => [ 'Delivery Order', '/delivery-order/index' ],
        "SalesInvoiceController" => [ 'Sales Invoice', '/sales-invoice/index' ],
      ];

      $sales_str = '';
      foreach($sales_menus as $sales_menu => $salesitem){
        if(isset($permissions[$sales_menu])){       
          $permission_data = $permissions[$sales_menu];
          if(in_array("index", $permission_data)){        
            $sales_str .= '<li>'.Html::a($salesitem[0], [$salesitem[1]], ['class'=>'']).'</li>';
          }
        }
      }
      if($sales_str){
        echo '<li class="dropdown"><a href="#">Sales</a><ul class="dropdown-menu">'.$sales_str.'</ul></li>';
      }
    }

    // returns the number as an anglicized string
    public function convertNum($num) {
        $ones = array( 
        1 => "one", 
        2 => "two", 
        3 => "three", 
        4 => "four", 
        5 => "five", 
        6 => "six", 
        7 => "seven", 
        8 => "eight", 
        9 => "nine", 
        10 => "ten", 
        11 => "eleven", 
        12 => "twelve", 
        13 => "thirteen", 
        14 => "fourteen", 
        15 => "fifteen", 
        16 => "sixteen", 
        17 => "seventeen", 
        18 => "eighteen", 
        19 => "nineteen" 
        ); 
        $tens = array( 
        1 => "ten",
        2 => "twenty", 
        3 => "thirty", 
        4 => "forty", 
        5 => "fifty", 
        6 => "sixty", 
        7 => "seventy", 
        8 => "eighty", 
        9 => "ninety" 
        ); 
        $hundreds = array( 
        "hundred", 
        "thousand", 
        "million", 
        "billion", 
        "trillion", 
        "quadrillion" 
        ); //limit t quadrillion 
        $num = number_format($num,$this->company->settings->decimal_places,".",","); 
        $num_arr = explode(".",$num); 
        $wholenum = $num_arr[0]; 
        $decnum = $num_arr[1]; 
        $whole_arr = array_reverse(explode(",",$wholenum)); 
        krsort($whole_arr); 
        $rettxt = ""; 
        foreach($whole_arr as $key => $i){ 
          if($i < 20){ 
            $rettxt .= $ones[$i]; 
          }elseif($i < 100){ 
            $rettxt .= $tens[substr($i,0,1)]; 
            $rettxt .= " ".$ones[substr($i,1,1)]; 
          }else{ 
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            $rettxt .= " ".$tens[substr($i,1,1)]; 
            $rettxt .= " ".$ones[substr($i,2,1)]; 
          } 
          if($key > 0){ 
            $rettxt .= " ".$hundreds[$key]." "; 
          } 
        } 
        if($decnum > 0){ 
          $rettxt .= " and fils "; 
        if($decnum < 20){ 
          $rettxt .= $ones[$decnum]; 
        }elseif($decnum < 100){ 
          $rettxt .= $tens[substr($decnum,0,1)]; 
          $rettxt .= " ".$ones[substr($decnum,1,1)]; 
        }elseif($decnum > 100){ 
        $rettxt .= $ones[substr($decnum,0,1)]." ".$hundreds[0]; 
        $rettxt .= " ".$tens[substr($decnum,1,1)]; 
        $rettxt .= " ".$ones[substr($decnum,2,1)]; 
        }  
        } 
        return $rettxt. " only"; 
    } 
    
}
