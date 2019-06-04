<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jobcard_vehicle".
 *
 * @property int $id
 * @property string $reg_num
 * @property string $chasis_num
 * @property string $make
 * @property string $model
 * @property string $odometer
 */
class JobcardVehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobcard_vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_num', 'chasis_num', 'make', 'model', 'color'], 'required'],         
            [['extended_warranty_type', 'amc_type', 'ew_expiry_kms'], 'integer'],  
            [['reg_num'], 'unique'],   
            ['chasis_num', 'string', 'min' => 17],
            [['tr_number', 'amc_expiry_date', 'ew_expiry_kms', 'ew_expiry_date', 'service_schedule', 'reg_num', 'make', 'model'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reg_num' => 'Veh.Reg.No',
            'chasis_num' => 'Chasis No',
            'make' => 'Make',
            'model' => 'Model',
        ];
    }
	public function getAmcType()
	{
		return $this->hasOne(AmcType::className(), ['id' => 'amc_type']);
		
	}
	public function getExtendedWarrantyType()
	{
		return $this->hasOne(ExtendedWarrantyType::className(), ['id' => 'extended_warranty_type']);
	}
}
