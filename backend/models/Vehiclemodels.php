<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "vehicle_models".
 *
 * @property int $id
 * @property int $manufacturer_id
 * @property int $name
 * @property int $type_id
 * @property string $created_date
 * @property int $status
 */
class Vehiclemodels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_models';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manufacturer_id', 'name','type_id'], 'required'],
            [['manufacturer_id', 'status'], 'integer'],
            // [['manufacturer_id'], 'integer'],
            [['created_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manufacturer_id' => 'Manufacturer',
            'name' => 'Model Name',
            'type_id' => 'Vehicle Type',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
    public function getManufacturer()
        {
            return $this->hasOne(Manufacturer::className(), ['id' => 'manufacturer_id']);
        }
    public function getVariants()
    {
        return $this->hasMany(Variants::className(), ['model_id' => 'id']);
    }
    public function getType()
    {
        return $this->hasOne(Vehicletype::className(), ['id' => 'type_id']);
    }
    public function variantList(){
        $out = "";
        foreach($this->variants as $variant){           
            $out .= '<li>'.$variant->name.Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->getUrlManager()->createUrl(['vehiclemodels/update-variant', 'id' =>$variant->id,]), [
            'title' => Yii::t('app', 'Update Variant'),
            ]).'</li>';                   
        }
        return $out;
    }
     public function getItem()
    {
        return $this->hasOne(Items::className('yes'), ['model_id' => 'id']);
    }
    
}
