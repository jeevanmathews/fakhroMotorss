<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "accessories".
 *
 * @property int $id
 * @property int $accessories_type_id
 * @property int $item_type_id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string $created_date
 * @property int $status
 */
class Accessories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accessories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['accessories_type_id', 'name', 'code', 'description','rate'], 'required'],
            [['accessories_type_id', 'status'], 'integer'],
            [['description'], 'string'],
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
            'accessories_type_id' => 'Accessories Type ',
            'item_type_id' => 'Item Type ',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'created_date' => 'Created Date',
            'status' => 'Status',
			'tax_enabled' => 'Tax Enabled',
			'tax_rate' =>'Tax Rate',
        ];
    }
    public function getAccessorytype(){
        return $this->hasOne(Accessoriestype::className(), ['id' => 'accessories_type_id']);
    }
    public function getGroup(){
        return $this->hasOne(Itemtype::className(), ['id' => 'item_type_id']);
    }
    public function getNamewithPrice(){
        return $this->name." - ".Yii::$app->common->company->settings->currency->code. " " .$this->rate." /unit";
    }
}
