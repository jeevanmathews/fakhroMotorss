<?php

namespace backend\controllers;

use Yii;
use backend\models\Branches;
use backend\models\BranchesSearch;
use backend\models\Company;
use backend\models\Country;
use backend\models\Branchtypes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;
/**
 * BranchesController implements the CRUD actions for Branches model.
 */
class BranchesController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
     * Lists all Branches models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BranchesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Branches model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $model->branchtype_id=Branchtypes::find()->where(['in', 'id', explode(',',$model->branchtype_id)])->all();
        $model->vat_expiry = date('d-m-Y',strtotime($model->vat_expiry));
        $model->cr_expiry = date('d-m-Y',strtotime($model->cr_expiry));
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Branches model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
 
        $model = new Branches();
        $countries = ArrayHelper::map(Country::find()->where(["status" => 1])->all(), 'id', 'name');
        $branchtypes = ArrayHelper::map(Branchtypes::find()->all(), 'id', 'type');
        $company=Company::find()->one();
        if(Yii::$app->request->post()){
            $data = Yii::$app->request->post();
            $branchtype_id = $data['Branches']['branchtype_id'];
           $data['Branches']['branchtype_id']=implode(',',$branchtype_id);
        if ($model->load($data) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			//echo $model->imageFile;
            $model->upload();
            return $this->redirect(['view', 'id' => $model->id]);
        }
}
        return $this->render('create', [
            'model' => $model,
            'countries'=>$countries,
            'company'=>$company->id,
            'branchtypes'=>$branchtypes,

        ]);
    }

    /**
     * Updates an existing Branches model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $countries = ArrayHelper::map(Country::find()->where(["status" => 1])->all(), 'id', 'name');
        $branchtypes = ArrayHelper::map(Branchtypes::find()->all(), 'id', 'type');
        $company=Company::find()->one();
        $model->vat_expiry = date('Y-m-d',strtotime($model->vat_expiry));
        $model->cr_expiry = date('Y-m-d',strtotime($model->cr_expiry));
        if(Yii::$app->request->post()){
            $data = Yii::$app->request->post();
            $branchtype_id = $data['Branches']['branchtype_id'];
            $data['Branches']['branchtype_id']=implode(',',$branchtype_id);
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->upload();
            if ($model->load($data) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'countries'=>$countries,
            'company'=>$company->id,
            'branchtypes'=>$branchtypes
        ]);
    }

    /**
     * Deletes an existing Branches model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

     /**
     * Change status of model.
     * If it is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public function actionChangeStatus($id){
        $model = $this->findModel($id);
        $model->status = ($model->status == 0)?1:0;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Branches model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branches the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branches::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
