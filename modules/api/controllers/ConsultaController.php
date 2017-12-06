<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 19/09/17
 * Time: 13:51
 */

namespace app\modules\api\controllers;


use app\models\Consulta;
use app\models\Paciente;
use app\models\ProfissionalSaude;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ConsultaController extends ActiveController
{
    public $modelClass = 'app\models\Consulta';
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
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
            'except' => ['options'],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];

        return $behaviors;
    }


    public function actionConsultas()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $token = Yii::$app->user->identity->getAuthKey();

        //mostra somente as consultas que não tiveram exames solicitados
        $query = Consulta::find()
            ->leftJoin('solicitacaoexames', 'codigoconsulta = codigo')
            ->innerJoin('profissionalsaude', 'numeroprofissionalsaude = profissionalsaude.numero')
            ->innerJoin('paciente', 'numeropaciente = paciente.numero')
            ->where(['profissionalsaude.authkey' => $token])
            ->andWhere('solicitacaoexames.codigoconsulta is null')
            ->asArray()
            ->all();

        return $query;
    }

    public function actionConsultasPacientes()
    {
        $request = Yii::$app->request;

        $situacao = $request->get('situacao');

        $query = Consulta::find()
            ->innerJoinWith('paciente')
            ->innerJoinWith('profissional')
            ->asArray()
            ->where(['paciente.authkey' => Yii::$app->user->identity->getAuthKey()])
            ->andWhere(['situacao' => $situacao])
            ->all();

        return $query;
    }

    public function actionCriar()
    {
        $request = Yii::$app->request;

        $acoes = [
            'senha_errada_profissional' => 0,
            'cpf_errado' => 1,
            'consulta_realizado' => 2,
            'erro_finaliza_cosulta' => 3,
            'senha_errada_pessoa' => 4
        ];

        $profissionalSaude = null;
        $paciente = null;

        if ($request->isPost){
            $dado = $request->post();
            $senha = $dado['senha'];

            $profissionalSaude = ProfissionalSaude::find()
                ->where(['authkey' => Yii::$app->user->identity->getAuthKey()])
                ->andWhere(['senha' => $senha])
                ->one();

            if (!empty($profissionalSaude)){
                $paciente = Paciente::findOne(['cpf' => $dado['cpf']]);

                if (!empty($paciente)){
                    $consulta = new Consulta();
                    $consulta->numeroprofissionalsaude = $profissionalSaude->numero;
                    $consulta->numeropaciente = $paciente->numero;

                    //pendente
                    $consulta->situacao = 'p';
                    $consulta->datacriacao= date('Y-m-d H:i:s');
                    $consulta->descricao = $dado['descricao'];

                    return $consulta->save(false) ? $acoes['consulta_realizado'] : $acoes['erro_finaliza_cosulta'];
                }else{
                    return $acoes['senha_errada_pessoa'];
                }
            }else{
                return $acoes['senha_errada_profissional'];
            }
        }

        return null;
    }

    public function actionFinalizarConsulta()
    {
        $request = Yii::$app->request;
        $codigo = $request->get('codigo');

        if (($model = Consulta::findOne($codigo)) !== null) {
            $model->dataconsulta = date('Y-m-d H:i:s');
            $model->situacao = 'f';

            return $model->save();
        } else {
            return false;
        }
    }
}