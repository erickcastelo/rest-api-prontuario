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
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

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
            'only' => ['finaliza', 'minhas-consultas'],
            'except' => ['options'],
        ];

        return $behaviors;
    }


    public function actionLogin()
    {
        $model = new LoginForm();

        $dados = $model->load(Yii::$app->getRequest()->getBodyParams(), '');

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
            ->innerJoinWith('cpfpessoa')
            ->innerJoinWith(' pfprofissionalsaude')
            ->asArray()
            ->where(['pessoa.authkey' => Yii::$app->user->identity->getAuthKey()])
            ->andWhere(['aceito' => 'p'])
            ->all();

        return $query;
    }

    public function actionInserir()
    {
        $model = new Paciente();

        $geraToken = md5(uniqid(rand(), true));
        $model->authkey = $geraToken;
        $model->datacriacao = date('Y-m-d H:i:s');

        $dados = $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($dados && $model->save()){

            return 1;
        }
        else{
            $model->validate();
            return $model->errors;
        }
    }
}