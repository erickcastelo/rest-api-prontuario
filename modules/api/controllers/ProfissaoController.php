<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 19/09/17
 * Time: 10:57
 */

namespace app\modules\api\controllers;


use app\models\Profissao;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class ProfissaoController extends ActiveController
{
    public $modelClass = 'app\models\Profissao';
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

    public function actionProfissoes()
    {
        $query = Profissao::find()
            ->asArray()
            ->orderBy('nome')
            ->all();

        return $query;
    }
}