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

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE, HEAD");
//header("Access-Control-Allow-Headers: Authorization, X-PINGOTHER, Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 1728000");
header('Access-Control-Allow-Credentials: true');
class PaisController extends ActiveController
{
    public $modelClass = 'app\models\Pais';
    public $enableCsrfValidation = false;

    public function behaviors() {

        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'GET', 'OPTIONS', 'HEAD'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Headers' => ['*'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Allow-Headers' => ['Content-Type', 'Authorization'],
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => [
                    'X-Pagination-Current-Page',
                    'X-Pagination-Page-Count',
                    'X-Pagination-Per-Page',
                    'X-Pagination-Total-Count'
                ],
            ],
            'except' => ['options'],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => [''],
            'except' => ['options'],
        ];

        return $behaviors;
    }

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