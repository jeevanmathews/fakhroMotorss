<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $role_id
 * @property int $branch_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class SignupForm extends \yii\db\ActiveRecord
{
    public $password;
    public $confirmPassword;
    public $branch_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash', 'branch_id', 'created_at', 'updated_at', 'username', 'email'], 'required', 'on' => ['register']],          
            ['email', 'email'],
            ['username', 'unique'],            
            ['email', 'unique'],           
            [['branch_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
             [['password','confirmPassword'], 'required', 'on' => ['register', 'changepassword']],            
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'on' => ['register', 'changepassword']],
            [['auth_key'], 'string', 'max' => 32],           
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'branch_id' => 'Branch ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function signup()
    {

        // if (!$this->validate()) {
        //    
        //     return null;
        // }
        
        $user = new SignupForm();
        $users = new User();
       
        $users->username = $this->username;
        $users->email = $this->email;
        $users->branch_id = $this->branch_id;
        $users->setPassword($this->password);
        $users->generateAuthKey();    
       // echo '<pre>';var_dump($users->save(false));echo'</pre>';die;
        return $users->save(false) ? $users : null;
    }
}
