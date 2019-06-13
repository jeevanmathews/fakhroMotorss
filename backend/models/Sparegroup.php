<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "itemgroup".
 *
 * @property int $id
 * @property int $type
 * @property int $parent_id
 * @property string $category_name
 * @property int $status
 */
class Sparegroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'itemgroup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type','category_name', 'status'], 'required'],
            [['parent_id', 'status'], 'integer'],
            [['type','category_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Type',
            'parent_id' => 'Parent ID',
            'category_name' => 'Category Name',
            'status' => 'Status',
        ];
    }
}
