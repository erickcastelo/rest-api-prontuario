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
use yii\console\Exception;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\Response;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE, HEAD");
header("Access-Control-Allow-Headers: Authorization, X-PINGOTHER, Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 1728000");
header('Access-Control-Allow-Credentials: true');
class PacienteController extends ActiveController
{

    public $modelClass = 'app\models\Paciente';
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
            'except' => ['options','login', 'finaliza', 'inserir', 'create'],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];

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
            return $model;
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



    public function actionInserir()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $model = new Paciente();

//        $geraToken = md5(uniqid(rand(), true));
//
//        $model->authkey = $geraToken;
//        $model->datacriacao = date('Y-m-d H:i:s');

        $dados = $model->load(Yii::$app->getRequest()->getBodyParams(), '');
//        $model->senha = Yii::$app->security->generatePasswordHash($model->senha);
        if ($dados && $model->save()){

            return $model;
        }

        else{

            // $model->validate();
            return $model;
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