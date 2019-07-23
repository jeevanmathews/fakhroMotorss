<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $contact_name
 * @property string $contact_number
 * @property string $email
 * @property string $alt_phone
 */
class Customer extends \yii\db\ActiveRecord
{
    public $customer_alt_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['email', 'email'],
            [['email'], 'unique'],
            ['customer_alt_id', 'safe'],
            [['name', 'contact_name', 'contact_number', 'email', 'alt_phone'], 'string', 'max' => 300],
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
            'contact_name' => 'Contact Name',
            'contact_number' => 'Contact Number',
            'email' => 'Email',
            'alt_phone' => 'Alternate Contact.No',
			'address' => 'Address',
        ];
    }
}
