<?php

namespace backend\models;

use Yii;
use yii\imagine\Image;
use backend\models\Country;
/**
 * This is the model class for table "branches".
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $code
 * @property string $mailing_name
 * @property string $address
 * @property int $country_id
 * @property string $state
 * @property string $zipcode
 * @property string $phone
 * @property string $email
 * @property string $fax
 * @property string $website
 * @property string $cr_number
 * @property string $cr_expiry
 * @property string $vat_number
 * @property string $vat_expiry
 * @property string $branchtype_id
 * @property string $created_at
 */
class Branches extends \yii\db\ActiveRecord
{
	public $imageFile;
    /**
     * {@inheritdoc}
     */
	
    public static function tableName()
    {
        return 'branches';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'country_id', 'status'], 'integer'],
            [['name', 'address', 'email', 'branchtype_id'], 'required'],
            [['address'], 'string'],
             [['email'], 'email'],
             [['phone'], 'number'],
             [['website'], 'url'],
            [['cr_expiry', 'vat_expiry', 'created_at'], 'safe'],
            [['name', 'mailing_name', 'phone', 'email'], 'string', 'max' => 300],
			[['imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' =>'200', 'minHeight' =>'200', 'on' =>  'register'],
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'minWidth' =>'200', 'minHeight' =>'200', 'on' => ['register', 'edit-profile']],
            [['code', 'zipcode', 'fax', 'cr_number', 'vat_number'], 'string', 'max' => 50],
            [['state', 'website'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company',
            'name' => 'Branch Name',
            'code' => 'Branch Code',
            'mailing_name' => 'Branch Contact Name',
            'address' => 'Branch Address',
            'country_id' => 'Country',
            'state' => 'State',
            'zipcode' => 'Postcode',
            'phone' => 'Phone',
            'email' => 'Email',
            'fax' => 'Fax',
            'website' => 'Website',
            'cr_number' => 'CR Number',
            'cr_expiry' => 'CR Expiry',
            'vat_number' => 'VAT Number',
            'vat_expiry' => 'VAT Expiry',
            'branchtype_id' => 'Branch Type',
            'created_at' => 'Created At',
			'logo' => 'Logo',
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
			    $this->imageFile->saveAs('../../backend/web/uploads/branches/' .$imgName);
                Image::thumbnail('../../backend/web/uploads/branches/'.$imgName, 75, 75)->save(Yii::getAlias('../../backend/web/uploads/branches/75_'.$imgName), ['quality' => 100]);
                if($this->logo){
                    unlink('../../backend/web/uploads/branches/'.$this->logo);
                    unlink('../../backend/web/uploads/branches/75_'.$this->logo);
                }
                $this->logo = $imgName;
                $this->imageFile = "";  
                return $this->save(false);
            }return true;
            
        } else {
            return false;
        }
    }
      public function getCompany()
        {
            return $this->hasOne(Company::className(), ['id' => 'company_id']);
        }
         public function getCountry()
        {
            return $this->hasOne(Country::className(), ['id' => 'country_id']);
        }
        public function getUser()
    {
        return $this->hasOne(User::className(), ['branch_id' => 'id']);
    }
     public function getBranchtype()
        {
            return $this->hasMany(Branchtypes::className(), ['id' => 'branchtype_id']);
        }
}
