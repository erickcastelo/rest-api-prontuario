<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 16/11/17
 * Time: 10:40
 */

namespace app\modules\api\controllers;


use app\models\Empresa;
use app\models\LoginEmpresa;
use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class EmpresaController extends Controller
{

    public $modelClass = 'app\models\Empresa';
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
            'except' => ['options','login', 'inserir', 'empresas'],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['about'],
            'rules' => [
                [
                    'actions' => ['about'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ];
        return $behaviors;
    }



    public function actionLogin()
    {
        $model = new LoginForm();

        $dados = $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->tipoSessao = 3;

        if ($dados && $model->login()) {
            return ['accesstoken' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model->errors;
        }
    }

    public function actionEmpresa()
    {
        $authkey =  Yii::$app->user->identity->getAuthKey();

        $query = Empresa::findOne(['authkey' =>$authkey]);

        return $query;
    }

    public function actionEmpresas()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        return Empresa::find()->all();
    }
}