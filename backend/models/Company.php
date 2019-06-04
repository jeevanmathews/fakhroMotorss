<?php

namespace backend\models;
use yii\imagine\Image;
use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
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
 * @property string $multi_branches
 * @property string $created_at
 */
class Company extends \yii\db\ActiveRecord
{
	public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address', 'email'], 'required'],
            ['email', 'email'],
            [['address', 'multi_branches', 'centrilized_warehouse'], 'string'],
            [['country_id', 'phone'], 'integer'],
            [['cr_expiry', 'vat_expiry', 'created_at'], 'safe'],
            [['name', 'mailing_name', 'email'], 'string', 'max' => 300],
            [['code', 'zipcode', 'fax', 'cr_number', 'vat_number'], 'string', 'max' => 50],
			[['imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' =>'200', 'minHeight' =>'200', 'on' =>  'register'],
            [['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'minWidth' =>'200', 'minHeight' =>'200', 'on' => ['register', 'edit-profile']],
            [['state', 'website', 'vat_format'], 'string', 'max' => 250],
            [['vat_rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Company Name',
            'code' => 'Code',
            'mailing_name' => 'Mailing Name',
            'address' => 'Address',
            'country_id' => 'Country',
            'state' => 'City',
            'zipcode' => 'Postcode',
            'phone' => 'Phone',
            'email' => 'Company Email',
            'fax' => 'Fax',
            'website' => 'Website',
            'cr_number' => 'CR Number',
            'cr_expiry' => 'CR Expiry',
            'vat_number' => 'VAT Number',
            'vat_expiry' => 'VAT Expiry',
            'multi_branches' => 'Multiple Branches',
            'created_at' => 'Created At',
			'logo' => 'Logo',
            'vat_rate' => 'Vat Rate (%)'
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
			    $this->imageFile->saveAs('../../backend/web/uploads/company/' .$imgName);
                Image::thumbnail('../../backend/web/uploads/company/'.$imgName, 75, 75)->save(Yii::getAlias('../../backend/web/uploads/company/75_'.$imgName), ['quality' => 100]);
                if($this->logo){
                    unlink('../../backend/web/uploads/company/'.$this->logo);
                    unlink('../../backend/web/uploads/company/75_'.$this->logo);
                }
                $this->logo = $imgName;
                $this->imageFile = "";  
                return $this->save(false);
            }return true;
            
        } else {
            return false;
        }
    }
    public function getBranches()
        {
            return $this->hasMany(Branches::className(), ['company_id' => 'id']);
        }
    public function getCountry()
        {
            return $this->hasOne(Country::className(), ['id' => 'country_id']);
        }   
    public function getSettings()
        {
            return $this->hasOne(CompanySettings::className(), ['company_id' => 'id']);
        }     
}
