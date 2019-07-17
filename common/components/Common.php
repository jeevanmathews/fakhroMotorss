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
     $company = PrefixMaster::find()->select(['id'])->where(['process'=> $process,'branch_id'=>Yii::$app->user->identity->branch_id,'status'=>1])->one();
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


}
