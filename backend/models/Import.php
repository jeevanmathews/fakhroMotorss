<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Import extends Model
{
    public $importfile;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
         [['importfile'], 'file'],
         // ['importfile', 'each', 'rule' => ['file']],
            // username and password are both required
            // [['username', 'password'], 'required'],
            // // rememberMe must be a boolean value
            // ['rememberMe', 'boolean'],
            // // password is validated by validatePassword()
            // ['password', 'validatePassword'],
        ];
    }
}