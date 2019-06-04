<?php

namespace common\components;

use Yii;
use yii\base\Component;

use backend\models\CompanySettings;
use backend\models\SignupForm;
use backend\models\Company;
use backend\models\PrefixMaster;
use backend\models\User;
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
     $company = PrefixMaster::find()->select(['id'])->where(['process'=> $process,'status'=>1])->one();
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


}
