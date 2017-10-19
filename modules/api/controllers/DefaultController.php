<?php

namespace app\modules\api\controllers;

use app\models\LoginForm;
use app\models\ProfissionalSaude;
use app\models\User;
use PHPUnit\Framework\Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `api` module
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE, HEAD");
//header("Access-Control-Allow-Headers: Authorization, X-PINGOTHER, Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 1728000");
header('Access-Control-Allow-Credentials: true');
//header("access-control-allow-origin: *");
//header('Access-Control-Allow-Credentials: null');
//header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
//header("Access-Control-Allow-Methods, GET, POST, DELETE, PUT, OPTIONS");
class DefaultController extends ActiveController
{
    public $enableCsrfValidation = false;
    public $modelClass = 'app\models\ProfissionalSaude';

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
            'only' => ['dashboard', 'teste'],
            'except' => ['options'],

        ];

        return $behaviors;

    }

    public function actionTeste()
    {
       return "teste";
    }

    public function actionDashboard()
    {
        /*$response = [
            'username' => Yii::$app->user->identity->getId(),
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];*/

        $response = [
            'username' => 'testes',
            'access_token' => 'teste',
        ];

        return $response;
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        $dados = $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($dados && $model->login()) {
            return ['accesstoken' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionInserir()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $model = new ProfissionalSaude();

        $geraToken = md5(uniqid(rand(), true));

        $model->authkey = $geraToken;
        $model->datacriacao = date('Y-m-d H:i:s');

        $dados = $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($dados && $model->save()){

            return true;
        }
        else{
            $model->validate();
            return $model;
        }
    }
}
