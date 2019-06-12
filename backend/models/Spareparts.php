<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "spare_parts".
 *
 * @property int $id
 * @property int $spare_type_id
 * @property int $item_type_id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string $created_date
 * @property int $status
 */
class Spareparts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'spare_parts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['spare_type_id', 'name', 'code', 'description','rate'], 'required'],
            [['spare_type_id', 'status'], 'integer'],
            [['description','tax_enabled'], 'string'],
			[['tax_rate','rate'], 'number'],
            [['created_date'], 'safe'],
            [['name'], 'string', 'max' => 300],
            [['code'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'spare_type_id' => 'Spare Type ',
            'item_type_id' => 'Item Type',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'created_date' => 'Created Date',
            'status' => 'Status',
			'rate' => 'Rate',
			'tax_enabled' => 'Tax Enabled',
			'tax_rate' =>'Tax Rate',
        ];
    }
    public function getSparetype(){
        return $this->hasOne(Sparetypes::className(), ['id' => 'spare_type_id']);
    }

    public function getGroup(){
        return $this->hasOne(Itemtype::className(), ['id' => 'item_type_id']);
    }

    public function getNamewithPrice(){
        return $this->name." - ".Yii::$app->common->company->settings->currency->code. " " .$this->rate." /unit";
    }
    public function getRate(){
        $price = Itempricing::find()->where(["item_id" => $this->id, 'type' => 'spares'])->one();
        return ($price)?$price->selling_price:0;
    }
}
