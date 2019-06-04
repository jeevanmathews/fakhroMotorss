<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_type".
 *
 * @property int $id
 * @property string $name
 * @property int $group_id
 * @property string $quantity_added
 * @property string $set_tax
 * @property string $created_at
 * @property int $status
 */
class Itemtype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'quantity_added', 'set_tax'], 'required'],
            [['group_id', 'status'], 'integer'],
            [['quantity_added', 'set_tax'], 'string'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 300],
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
            'group_id' => 'Group ID',
            'quantity_added' => 'Quantity Added',
            'set_tax' => 'Set Tax',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
    public function getGroup()
    {
        return $this->hasOne(Itemtype::className('yes'), ['id' => 'group_id']);
    }
    public function getSpare()
    {
        return $this->hasOne(Spareparts::className(), ['item_type_id' => 'id']);
    }
    public function getAccessory()
    {
        return $this->hasOne(Accessories::className(), ['accessories_type_id' => 'id']);
    }
    
}
