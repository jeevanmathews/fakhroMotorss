<?php

namespace backend\controllers;

use Yii;
use backend\models\Jobcard;
use backend\models\Customer;
use backend\models\JobcardVehicle;
use backend\models\JobcardVehicleSearch;
use backend\models\JobcardSearch;
use backend\models\CustomerSearch;
use backend\models\JobcardTask;
use backend\models\JobcardMaterial;
use backend\models\JobcardTaskLog;
use backend\models\JobcardInvoice;
use backend\models\JobcardInvoiceMaterial;
use backend\models\JobcardInvoiceTask;
use backend\models\JobcardQuotation;
use backend\models\JobcardQuotationMaterial;
use backend\models\JobcardQuotationTask;
use backend\models\User;
use backend\models\Employees;
use backend\models\TempQuotation;
use backend\models\ItemsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;

/**
 * JobcardController implements the CRUD actions for Jobcard model.
 */
class ReportsController extends Controller
{
    /**
     * {@inheritdoc}
     */
	
	public function beforeAction($action)
    {       
        Yii::$app->common->checkPermission('ReportsController', Yii::$app->controller->action->id);
        return parent::beforeAction($action);  
    }

 
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Jobcard models.
     * @return mixed
     */
    public function actionBelowstockItems()
    {
        $count = Yii::$app->db->createCommand('
                SELECT count(*) FROM `stock_history` left join items on items.id = stock_history.item_id where stock_history.id in (select max(id)from `stock_history` group by `item_id`) and stock_history.current_stock <= 0')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT items.item_name, items.type, items.item_code, stock_history.current_stock FROM `stock_history` left join items on items.id = stock_history.item_id where stock_history.id in (select max(id)from `stock_history` group by `item_id`) and stock_history.current_stock <= 0',              
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'item_name',
                    'current_stock'
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $page_id = "report_outofstock".time();

        return $this->renderAjax('outofstocks', [      
        'dataProvider' => $dataProvider,
        'page_id' => $page_id
        ]);
    }

    /**
     * Displays Jobcard service report.
     * @param mixed(date ranges, branch etc.) 
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionService()
    {
        $get = Yii::$app->request->queryParams;
        if($get){
            $condn = "";
            //$condn .= ($get['report_branch_id'])?(" and branch_id = ".$get['report_branch_id']):"";
            //$get['date_from'];
            //$get['date_to'];
        }
        $count = Yii::$app->db->createCommand('SELECT count(*) FROM `jobcard_invoice` WHERE id in (select max(id) from jobcard_invoice group by jobcard_id)')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM `jobcard_invoice` WHERE id in (select max(id) from jobcard_invoice group by jobcard_id)',              
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'discount',
                    'tax',
                    'amount_due'
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $page_id = "report_service".time();

        return $this->renderAjax('services', [      
        'dataProvider' => $dataProvider,
        'page_id' => $page_id
        ]);
    }

    /**
     * Displays Purchase Order Report
     * @param mixed(date ranges, branch etc.) 
     * @return mixed
     */
    public function actionPurchaseOrder()
    { 

    }   
}
