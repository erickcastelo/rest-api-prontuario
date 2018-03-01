<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 15/10/17
 * Time: 13:45
 */

namespace app\modules\api\controllers;


use app\models\Classificacao;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\Response;

class ClassificacaoController extends ActiveController
{

    public $modelClass = 'app\models\Classificacao';
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],
            'except' => ['*'],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];

        return $behaviors;
    }


//    public function actionListClassificacao()
//    {
//        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
//
//        $query = Classificacao::find()->asArray()->all();
//
//        return $query;
//    }
}