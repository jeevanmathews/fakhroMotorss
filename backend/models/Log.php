<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property string $controller
 * @property string $action
 * @property string $query_string
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['controller', 'action', 'query_string', 'loggedin_user'], 'required'],
            [['controller', 'action', 'query_string', 'date'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'query_string' => 'Query String',
        ];
    }

    public function getLoggedinuser(){
        return $this->hasOne(User::className(), ['id' => 'loggedin_user']);
    }

    public function beforeSave($insert)
    {
         if (parent::beforeSave($insert)) {
            $this->date = date("Y-m-d h:i:s");
            return true;
        }
    }
}
