<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 27/09/17
 * Time: 15:08
 */

namespace app\modules\api\controllers;


use app\models\ExameLaboratorial;
use app\models\SolicitacaoExames;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\Response;

class ExameController extends ActiveController
{
    public $modelClass = 'app\models\SolicitacaoExames';
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
            'except' => [''],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];

        return $behaviors;
    }

    public function actionExamesLaboratorial()
    {
        $query = ExameLaboratorial::find()
            ->where('possui is null')
            ->asArray()
            ->all();

        return $query;
    }

    public function actionSolicitarExame()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $request = Yii::$app->request;
        $array = [];

        $solicitacaoExames = new SolicitacaoExames();

        if ($request->isPost){
            $exames = $request->post();
            foreach ($exames as $item){
                array_push($array, Json::decode($item));
            }

            return \Yii::$app->db
                ->createCommand()
                ->batchInsert(SolicitacaoExames::tableName(),
                    ['numeroexamelaboratorial', 'codigoconsulta', 'datacriacao'], $array)
                ->execute();
        }
    }
}