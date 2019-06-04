<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "company_settings".
 *
 * @property int $id
 * @property int $company_id
 * @property string $financial_year
 * @property string $books_beginning
 * @property int $currency_id
 * @property int $decimal_places
 * @property string $suffix_symbol
 * @property int $decimal_places_words
 * @property string $enable_space
 * @property string $date_format
 * @property int $status
 * @property string $created_at
 */
class CompanySettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'enable_space'], 'required'],
            [['company_id', 'currency_id', 'decimal_places', 'status'], 'integer'],
            [['financial_year', 'books_beginning', 'created_at'], 'safe'],
            [['suffix_symbol', 'enable_space', 'date_format'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'financial_year' => 'Financial Year',
            'books_beginning' => 'Books Beginning',
            'currency_id' => 'Currency',
            'decimal_places' => 'No Of Decimal Places',
            'suffix_symbol' => 'Suffix Symbol',
            'decimal_places_words' => 'Decimal Places Words',
            'enable_space' => 'Enable Space Between Amount and Symbol',
            'date_format' => 'Date Format',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public function getCurrency()
        {
            return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
        } 
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    } 
}
