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
            [['name'], 'required'],
            [['status'], 'integer'],
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
            'status' => 'Status',
        ];
    }

    public function getUsers()
    {
        return $this->hasOne(User::className(), ['role_id' => 'id']);
    }

    public function getPermissions(){
        return $this->hasMany(RolePermission::className(), ['role_id' => 'id']);
    }

    public function getPermissionAry(){
        $permissions = [];
        foreach ($this->permissions as $permission) {
           $permissions[] = $permission->permission_id;
        }
        return $permissions;
    }
    
}
