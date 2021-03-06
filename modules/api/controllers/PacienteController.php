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
use Yii;

class PacienteController extends StandardController
{

    public $modelClass = 'app\models\Paciente';
    public $exceptions = ['options','login', 'create'];

    public function actionLogin()
    {
        $model = new LoginForm();

        $dados = $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->tipoSessao = 2;

        if ($dados && $model->login()) {
            return ['user' => Paciente::findOne(['id' => Yii::$app->user->identity->getId()])];
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