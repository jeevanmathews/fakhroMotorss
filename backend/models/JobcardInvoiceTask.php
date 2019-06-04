<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jobcard_invoice_task".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $task_id
 * @property int $mechanic_id
 * @property string $start_date_time
 * @property string $end_date_time
 * @property double $total_time
 * @property string $billable
 * @property double $task_rate
 * @property double $discount_percent
 * @property double $discount_amount
 * @property string $tax_enabled
 * @property double $tax_rate
 * @property double $tax_amount
 * @property double $billing_rate
 * @property string $note
 * @property string $status
 */
class JobcardInvoiceTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobcard_invoice_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'task_id', 'note'], 'required'],
            [['invoice_id', 'task_id', 'mechanic_id'], 'integer'],
            [['total_time', 'task_rate', 'discount_percent', 'discount_amount', 'tax_rate', 'tax_amount', 'billing_rate'], 'number'],
            [['billable', 'tax_enabled', 'note', 'status'], 'string'],
            [['start_date_time', 'end_date_time'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'task_id' => 'Task ID',
            'mechanic_id' => 'Mechanic ID',
            'start_date_time' => 'Start Date Time',
            'end_date_time' => 'End Date Time',
            'total_time' => 'Total Time',
            'billable' => 'Billable',
            'task_rate' => 'Task Rate',
            'discount_percent' => 'Discount Percent',
            'discount_amount' => 'Discount Amount',
            'tax_enabled' => 'Tax Enabled',
            'tax_rate' => 'Tax Rate',
            'tax_amount' => 'Tax Amount',
            'billing_rate' => 'Billing Rate',
            'note' => 'Note',
            'status' => 'Status',
        ];
    }

    public function getTask(){
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }
}
