<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $date_of_joining
 * @property string $date_of_birth
 * @property int $department_id
 * @property int $designation_id
 * @property int $login
 * @property int $user_id
 * @property string $created_date
 * @property int $status
 */
class Employees extends \yii\db\ActiveRecord
{
    public $department;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'address', 'email', 'phone', 'date_of_joining', 'date_of_birth', 'designation_id', 'branch_id'], 'required'],
            [['address'], 'string'],
            ['email', 'email'],
            ['email', 'unique'], 
            ['phone', 'unique'],  
            [['date_of_joining', 'date_of_birth', 'created_date'], 'safe'],
            [['designation_id', 'login', 'user_id', 'status', 'branch_id'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 250],           
            [['phone'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address' => 'Address',
            'email' => 'Email',
            'phone' => 'Phone',
            'date_of_joining' => 'Date Of Joining',
            'date_of_birth' => 'Date Of Birth',          
            'designation_id' => 'Designation',
            'login' => 'Login',
            'user_id' => 'User ID',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
     public function getUser()
    {
        return $this->hasOne(User::className('yes'), ['id' => 'user_id']);
    }
    
    public function getDesignation()
    {
        return $this->hasOne(Designations::className('yes'), ['id' => 'designation_id']);
    }
    public function getFullname()
    {
        return $this->first_name." ".$this->last_name;
    }
}
