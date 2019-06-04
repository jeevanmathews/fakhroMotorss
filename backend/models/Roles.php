<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string $name
 * @property int $department_id
 * @property int $status
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'department_id' => 'Department',
            'status' => 'Status',
        ];
    }
       public function getUsers()
        {
            return $this->hasOne(User::className(), ['role_id' => 'id']);
        }
    public function getDepartments()
        {
            return $this->hasOne(Departments::className(), ['id' => 'department_id']);
        }
}
