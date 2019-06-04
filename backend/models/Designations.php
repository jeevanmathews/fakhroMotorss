<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "designations".
 *
 * @property int $id
 * @property string $name
 * @property string $created_date
 * @property int $status
 */
class Designations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'designations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'department_id'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 300],
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
    public function getEmployee()
    {
        return $this->hasOne(Employees::className('yes'), ['designation_id' => 'id']);
    }

    public function getDepartment()
    {
        return $this->hasOne(Departments::className(), ['id' => 'department_id']);
    }
}
