<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "role_permission".
 *
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 * @property int $status
 */
class RolePermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'permission_id'], 'required'],
            [['role_id', 'permission_id', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'permission_id' => 'Permission ID',
            'status' => 'Status',
        ];
    }
    public function getPermissionmaster()
        {
            return $this->hasOne(PermissionMaster::className(), ['id' => 'permission_id']);
        }
}
