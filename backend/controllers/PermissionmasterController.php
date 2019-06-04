<?php

namespace backend\controllers;

use Yii;
use backend\models\PermissionMaster;
use backend\models\RolePermission;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PermissionmasterController implements the CRUD actions for PermissionMaster model.
 */
class PermissionmasterController extends Controller
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
     * Lists all PermissionMaster models.
     * @return mixed
     */
    public function actionIndex()
    {


    // return $fulllist;

        $dataProvider = new ActiveDataProvider([
            'query' => PermissionMaster::find(),
        ]);
         $fulllist = new ActiveDataProvider([
            'query' => PermissionMaster::findallactions(),
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'data'         => $fulllist,
        ]);
    }

    /**
     * Displays a single PermissionMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PermissionMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PermissionMaster();
              $controllerlist = [];
    if ($handle = opendir('../controllers')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                $controllerlist[] = $file;
            }
        }
        closedir($handle);
    }
    asort($controllerlist);
    $fulllist = [];
    foreach ($controllerlist as $controller):
        $handle = fopen('../controllers/' . $controller, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (preg_match('/public function action(.*?)\(/', $line, $display)):
                    if (strlen($display[1]) > 2):
                        // $fulllist[]=array('module'=>substr($controller, 0, -4),'action'=>strtolower($display[1]));
                       
                        if(! PermissionMaster::find()->where(['module'=>substr($controller, 0, -4),'action'=>strtolower($display[1])])->exists())
                        {                    
                          $fulllist[]=array(substr($controller, 0, -4),strtolower($display[1]));
                        } 
                       
                        // $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                    endif;
                endif;
            }
        }
        fclose($handle);
        endforeach;
    // echo '<pre>';var_dump($fulllist);echo '</pre>';die;
    // return $fulllist;

          Yii::$app->db
            ->createCommand()
            ->batchInsert('permissions', ['module','action'],$fulllist)
            ->execute();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

           return $this->redirect(['index']);
    }

    /**
     * Updates an existing PermissionMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PermissionMaster model.
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
     * Finds the PermissionMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PermissionMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PermissionMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     public function actionDashboard()
    {
        return $this->render('dashboard');
    }
     public function actionPermissions()
    {
        $permittedids=array();
        $id = (int) Yii::$app->request->get('id');
        $permitted=RolePermission::find()->where(['role_id'=>$id])->select(['permission_id'])->all(); 
         if($permitted){
            foreach ($permitted as $value) {
               $permittedids[]=$value['permission_id'];
            }
         }

                // echo '<pre>';var_dump($permittedids);echo '</pre>';
         // die;
           // echo '<pre>';var_dump($permitted);echo '</pre>';die;
        $dataProvider = new ActiveDataProvider([
            'query' => PermissionMaster::find()
            ->joinWith(['rolepermission'])
            ->select(['permissions.*'])
            ->where(['not in', 'permissions.id', $permittedids]),
        ]);

         $datas = new ActiveDataProvider([
            'query' => PermissionMaster::find()
            ->InnerjoinWith(['rolepermission'])
            ->select(['permissions.*'])
            ->Where(['=', 'role_permission.role_id',$id ])
            // ->groupBy('RELATION_FIELD(Example: reviews.book_id)')
            // ->orderBy(['cnt' => 'DESC']),
        ]);


        return $this->render('../roles/permissions', [
            'dataProvider' => $dataProvider,
            'role_id'       =>$id,
            // 'permitted'    => $permittedids,
            'permitted'    => $datas
        ]);
    }
}
