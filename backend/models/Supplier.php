<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone 
 * @property string $vat_number
 * @property int $address
 * @property string $status
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vat_number','name', 'email', 'phone', 'address', 'status'], 'required'],
            ['email', 'email'],         
            [['address'], 'string'],
            [['name', 'email', 'phone'], 'string', 'max' => 300],
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
            'vat_number' => 'VAT Number',
            'phone' => 'Phone',
            'address' => 'Address',
            'status' => 'Status',
			'supplier_groupid' => 'Supplier Group',
        ];
    }
     public function getPurchaserequest()
    {
        return $this->hasOne(Purchaserequest::className(), ['supplier_id' => 'id']);
    }
    public function getItem()
    {
        return $this->hasOne(Items::className('yes'), ['supplier_id' => 'id']);
    }
}
