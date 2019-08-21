<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "sales_invoice".
 *
 * @property int $id
 * @property int $do_id 
 * @property int $prefix_id
 * @property int $branch_id
 * @property string $inv_number
 * @property string $inv_created_date
 * @property string $inv_date
 * @property int $inv_created_by
 * @property int $customer_id
 * @property double $subtotal
 * @property string $discount_type
 * @property double $discount
 * @property double $discount_percent
 * @property double $net
 * @property double $vat_percent
 * @property double $total_tax
 * @property double $grand_total
 * @property string $process_status
 * @property string $remarks
 * @property int $status
 */
class SalesInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['do_id', 'prefix_id', 'inv_created_by', 'customer_id','branch_id', 'status'], 'integer'],
            [['prefix_id', 'inv_number', 'inv_date', 'inv_created_by', 'customer_id'], 'required'],
            [['inv_created_date'], 'safe'],
            [['remarks','process_status','discount_type'], 'string'],
            [['subtotal','discount','discount_percent','net','vat_percent','total_tax','grand_total'], 'number'],
            [['inv_number'], 'string', 'max' => 200],
            [['inv_date'], 'string', 'max' => 300],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'do_id' => 'Do ID',
            'prefix_id' => 'Prefix',
            'inv_number' => 'Invoice Number',
            'inv_created_date' => 'Invoice Created Date',
            'inv_date' => 'Invoice Date',
            'inv_created_by' => 'Invoice Created By',
            'customer_id' => 'Customer ID',
            'subtotal' => 'Subtotal',
            'discount' => 'Discount',
            'total_tax' => 'Total Tax',
            'grand_total' => 'Grand Total',
            'status' => 'Status',
        ];
    }

     public function getInvoiceitems()
    {
        return $this->hasMany(SalesInvoiceItems::className(), ['inv_id' => 'id']);
    }
      public function getDo()
    {
        return $this->hasOne(DeliveryOrder::className(), ['id' => 'do_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'inv_created_by']);
    }
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
    public function getPrefix()
    {
        return $this->hasOne(PrefixMaster::className(), ['id' => 'prefix_id']);
    }
    public function updateStockDetails(){
        foreach($this->invoiceitems as $invoiceitems){
            $tot_reduced = 0;
            $tot_added = 0;
            $prev_stock = StockHistory::find()->where(["type" => $invoiceitems->material_type, 'item_id' => $invoiceitems->material_id, 'branch_id' => $this->branch_id])->orderBy('id desc')->limit(1)->one();

            $stock = new StockHistory();
            $stock->type = $invoiceitems->material_type;
            $stock->item_id = $invoiceitems->material_id;
            $stock->order_id = $this->id;
            $stock->source_type='sales-invoice';
            $stock->branch_id = $this->branch_id; 
            $stock->previous_stock = $prev_stock->current_stock;
            $stock->date = date("Y-m-d");
            if(StockHistory::find()->where(["type" => $invoiceitems->material_type, "order_id" => $this->id, 'item_id' => $invoiceitems->material_id, 'branch_id' => $this->branch_id])->count()){
                // Stock corrections done earlier
                $prev_stocks = StockHistory::find()->where(["type" => $invoiceitems->material_type, "order_id" => $this->id, 'item_id' => $invoiceitems->material_id, 'branch_id' => $this->branch_id])->all();
                foreach($prev_stocks as $jc_stock){
                    $tot_reduced += $jc_stock->reduced_stock;
                    $tot_added += $jc_stock->opening_stock;
                }
                $tot_used = $tot_reduced - $tot_added;
                if($invoiceitems->num_unit > $tot_used){
                    $additional_num = $invoiceitems->num_unit - $tot_used;
                    $stock->reduced_stock = $additional_num;
                    $stock->opening_stock = 0;
                    $stock->current_stock = ($prev_stock->current_stock - $additional_num);
                }else{
                    $return_stock = $tot_used - $invoiceitems->num_unit;
                    $stock->opening_stock = $return_stock;
                    $stock->reduced_stock = 0;
                    $stock->current_stock = ($prev_stock->current_stock + $return_stock);
                }
            }else{
                $stock->opening_stock = 0;
                $stock->reduced_stock = $invoiceitems->num_unit;
                $stock->current_stock = ($prev_stock->current_stock - $invoiceitems->num_unit);
            }
            if($stock->opening_stock == 0 && $stock->reduced_stock == 0){
                continue;
            }else {            
                if($stock->save()){
                    //Update Stock Distribution
                    //Case 1 reduce stock         
                    if($stock->reduced_stock != 0){
                        $stock_tobe_reduced = $stock->reduced_stock;
                        $stock_distributions = Yii::$app->db->createCommand("SELECT * FROM `stock_distribution` d WHERE id in( select max(id) from stock_distribution where item_id = ".$stock->item_id." and type='".$stock->type."' group by `code`) and item_id = ".$stock->item_id." and type='".$stock->type."' and current_stock != 0 order by (SELECT min(id) FROM `stock_distribution` where `type`='".$stock->type."' and `item_id` = ".$stock->item_id." and code = d.code) asc")->queryAll();
                      
                        foreach($stock_distributions as $stock_distribution) {
                            if($stock_tobe_reduced > 0){
                                $stockDistribution = new StockDistribution();
                                $stockDistribution->item_id = $stock->item_id;
                                $stockDistribution->type = $stock->type;            
                                $stockDistribution->order_id = $stock->order_id;
                                $stockDistribution->stock_id = $stock_distribution['stock_id'];
                                $stockDistribution->code = $stock_distribution['code'];
                                $stockDistribution->opening_stock = 0;
                                // $stockDistribution->used_status = $used_status;
                                if($stock_distribution['current_stock'] >= $stock_tobe_reduced){
                                    $stockDistribution->previous_stock = $stock_distribution['current_stock']; 
                                    $stockDistribution->reduced_stock = $stock_tobe_reduced;
                                    $stockDistribution->current_stock = ($stock_distribution['current_stock'] - $stock_tobe_reduced);
                                    $stockDistribution->save();
                                    $stock_tobe_reduced = 0;
                                }else{
                                   $stock_tobe_reduced = $stock_tobe_reduced - $stock_distribution['current_stock'];
                                   $stockDistribution->previous_stock = $stock_distribution['current_stock'];
                                   $stockDistribution->reduced_stock = $stock_distribution['current_stock'];
                                   $stockDistribution->current_stock = 0;
                                }
                                $stockDistribution->save();
                            }                            
                        }

                    } else if($stock->opening_stock != 0){//Case 2 Return stock
                        $return_distribution = $stock->opening_stock;
                        $stock_distributions = Yii::$app->db->createCommand("SELECT * FROM `stock_distribution` WHERE `order_id` = ".$stock->order_id." order by id desc")->queryAll();
                        foreach($stock_distributions as $stock_distribution){
                            if($return_distribution > 0){
                                $stockDistribution = new StockDistribution();
                                $stockDistribution->item_id = $stock->item_id;
                                $stockDistribution->type = $stock->type;            
                                $stockDistribution->order_id = $stock->order_id;
                                $stockDistribution->stock_id = $stock_distribution['stock_id'];
                                $stockDistribution->code = $stock_distribution['code'];

                                //last stock by code and item
                                $last_stockdistribution = StockDistribution::find()->where(['item_id' => $stock->item_id, 'stock_id' => $stock_distribution['stock_id'], 'code' => $stock_distribution['code']])->orderBy('id desc')->limit(1)->one();

                                $stockDistribution->previous_stock = $last_stockdistribution->current_stock;
                                if($stock_distribution['reduced_stock'] > $return_distribution ){
                                    $stockDistribution->opening_stock = $return_distribution;
                                    $stockDistribution->current_stock = $return_distribution + $last_stockdistribution->current_stock;
                                    $return_distribution = 0;
                                }else{
                                    $return_distribution = $return_distribution - $stock_distribution['reduced_stock'];
                                    $stockDistribution->opening_stock = $stock_distribution['reduced_stock'];
                                    $stockDistribution->current_stock = $stock_distribution['reduced_stock'] + $last_stockdistribution->current_stock;
                                }
                                $stockDistribution->save(); 
                            }

                        }

                    } 
                }
            }
        }
        //Update all stock status (to => used) for the jobcard which is invoiced
        // if($used_status == "used"){
        //     StockDistribution::updateAll(['used_status' => "used"], 'order_id = '.$this->id.' AND used_status = "hold"');
        // }
        return true;  
        
    }    
}
