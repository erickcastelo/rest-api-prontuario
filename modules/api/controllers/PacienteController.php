<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 24/08/17
 * Time: 09:53
 */

namespace app\modules\api\controllers;


use app\models\Consulta;
use app\models\LoginForm;
use app\models\Paciente;
use app\models\Pessoa;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\Response;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE, HEAD");
//header("Access-Control-Allow-Headers: Authorization, X-PINGOTHER, Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 1728000");
header('Access-Control-Allow-Credentials: true');
class PacienteController extends ActiveController
{

    public $modelClass = 'app\models\Pessoa';
    public $enableCsrfValidation = false;

    public function behaviors() {

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
            'except' => ['options','login', 'finaliza'],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];
//
//        $behaviors['access'] = [
//            'class' => AccessControl::className(),
//            'only' => ['about'],
//            'rules' => [
//                [
//                    'actions' => ['about'],
//                    'allow' => true,
//                    'roles' => ['@'],
//                ],
//            ],
//        ];
//
//        $behaviors['verbs'] = [
//            'class' => VerbFilter::className(),
//            'actions' => [
//                'logout' => ['post'],
//            ],
//        ];
        return $behaviors;
    }


    public function actionLogin()
    {
        $model = new LoginForm();

        $dados = $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->tipoSessao = 2;

        if ($dados && $model->login()) {
            return ['accesstoken' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model->errors;
        }
    }

    public function actionFinaliza()
    {
        $request = Yii::$app->request;

        $id = $request->post('id');
        $aceito = $request->post('aceito');

        $model = Consulta::findOne($id);

        $model->id = $id;
        $model->aceito = $aceito;

        return $model->save();
    }

    public function actionMinhasConsultas()
    {
        $query = Consulta::find()
            ->innerJoinWith('paciente')
            ->innerJoinWith('profissional')
            ->asArray()
            ->where(['paciente.authkey' => Yii::$app->user->identity->getAuthKey()])
            ->andWhere(['situacao' => 'p'])
            ->all();

        return $query;
    }

    public function actionInserir()
    {
        $model = new Paciente();

        $geraToken = md5(uniqid(rand(), true));

        $dados = Yii::$app->getRequest()->getBodyParams();
        $dados = isset($dados[0]) ? $dados[0] : $dados;

        $dados = $model->load($dados, '');

        $model->authkey = $geraToken;
        $model->datacriacao = date('Y-m-d H:i:s');

        if ($dados && $model->save()){

            return 1;
        }
        else{
            $model->validate();
            return $model->errors;
        }
    }

    public function actionListPacientes()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $query = Paciente::find()
            ->orderBy('nome')
            ->asArray()
            ->all();

        return $query;
    }

    public function actionPaciente()
    {
        $authkey =  Yii::$app->user->identity->getAuthKey();

        $query = Paciente::findOne(['authkey' =>$authkey]);

        return $query;
    }
}