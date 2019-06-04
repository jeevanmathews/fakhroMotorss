<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "permissions".
 *
 * @property int $id
 * @property string $module
 * @property string $action
 * @property int $status
 */
class PermissionMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['module', 'action'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module' => 'Module',
            'action' => 'Action',
            'status' => 'Status',
        ];
    }
    public function getRolepermission()
    {
        return $this->hasOne(RolePermission::className(), ['permission_id' => 'id']);
    }
    public static function findallactions(){

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
        // echo '<pre>';var_dump(substr($controller, 0, -14));echo '</pre>';
        $handle = fopen('../controllers/' . $controller, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (preg_match('/public function action(.*?)\(/', $line, $display)):
                    if (strlen($display[1]) > 2):
                        // $fulllist[]=array('module'=>substr($controller, 0, -4),'action'=>strtolower($display[1]));
                        $fulllist[]=array(substr($controller, 0, -4),strtolower($display[1]));
                        // $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                    endif;
                endif;
            }
        }
        fclose($handle);
    endforeach;
    // die;
    // echo '<pre>';var_dump($fulllist);echo '</pre>';die;
    return $fulllist;
    }
}
