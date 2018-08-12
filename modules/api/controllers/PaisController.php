<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 17/09/17
 * Time: 19:13
 */

namespace app\modules\api\controllers;

use app\models\Pais;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class PaisController extends StandardController
{
    public $modelClass = 'app\models\Pais';
    public $exceptions = ['options', 'paises'];

    public function actionPaises()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $query = Pais::find()
            ->select('codigo, nome')
            ->asArray()
            ->orderBy('nome')
            ->all();

        return $query;
    }
}