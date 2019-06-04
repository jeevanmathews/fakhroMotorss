<?php

namespace backend\models;

use Yii;
use yii\imagine\Image;


/**
 * This is the model class for table "manufacturer".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $logo
 * @property string $status
 */
class Manufacturer extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manufacturer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'address', 'status'], 'required'],
            [['address'], 'string'],
             ['email', 'email'],   
            [['name', 'email', 'phone'], 'string', 'max' => 300],
            [['imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' =>'200', 'minHeight' =>'200', 'on' =>  'register'],
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'minWidth' =>'200', 'minHeight' =>'200', 'on' => ['register', 'edit-profile']],
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
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'logo' => 'Logo',
            'status' => 'Status',
        ];
    }

    public function upload($validate = true)
    {
        $continue = true;
        if($validate){           
            $continue =  $this->validate()?true:false;
        }
        if ($continue) {
            if(isset($this->imageFile)){
                $imgName = Yii::$app->common->randomName().$this->id .'.' . $this->imageFile->extension;
                $this->imageFile->saveAs('../../backend/web/uploads/manufacturer/' .$imgName);
                Image::thumbnail('../../backend/web/uploads/manufacturer/'.$imgName, 75, 75)->save(Yii::getAlias('../../backend/web/uploads/manufacturer/75_'.$imgName), ['quality' => 100]);
                if($this->logo){
                    unlink('../../backend/web/uploads/manufacturer/'.$this->logo);
                    unlink('../../backend/web/uploads/manufacturer/75_'.$this->logo);
                }
                $this->logo = $imgName;
                $this->imageFile = "";  
                return $this->save(false);
            }return true;
            
        } else {
            return false;
        }
    }
    public function getModels()
        {
            return $this->hasMany(Vehiclemodels::className(), ['manufacturer_id' => 'id']);
        }
}
