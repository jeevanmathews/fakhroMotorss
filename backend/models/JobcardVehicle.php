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
    public $manufacturer;
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
            [['reg_num', 'chasis_num', 'make_id', 'model_id', 'vehicle_type'], 'required'],         
            [['extended_warranty_type', 'make_id', 'model_id', 'amc_type', 'ew_expiry_kms', 'customer_id'], 'integer'],  
            [['reg_num'], 'unique'],   
            ['chasis_num', 'string', 'min' => 17],
            [['tr_number', 'amc_expiry_date', 'ew_expiry_kms', 'ew_expiry_date', 'service_schedule', 'reg_num', 'vin', 'lpo_num', 'wo_num', 'color'], 'string', 'max' => 200],
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
            'make_id' => 'Make',
            'model_id' => 'Model',
            'customer_id' => 'Customer',
            'vin' => 'VIN',
            'lpo_num' => 'LPO No',
            'wo_num' => 'W/O No'
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

    public function getMake()
    {
        return $this->hasOne(Manufacturer::className(), ['id' => 'make_id']);
    }

    public function getModel()
    {
        return $this->hasOne(CarModel::className(), ['id' => 'model_id']);
    }
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
    public function getVehicletype()
    {
        return $this->hasOne(Vehicletype::className(), ['id' => 'vehicle_type']);
    }
}
