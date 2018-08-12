<?php

namespace app\models;

use Yii;
use yii\validators\EmailValidator;
use yiibr\brvalidator\CpfValidator;

/**
 * This is the model class for table "paciente".
 *
 * @property integer $id
 * @property string $email
 * @property string $rg
 * @property string $cpf
 * @property string $accesstoken
 * @property string $authkey
 * @property string $datacriacao
 * @property string $dataalteracao
 * @property string $fone
 * @property string $datanascimento
 * @property string $nome
 * @property string $senha
 * @property integer $codpais
 * @property string $responsavel
 * @property string $numero
 * @property string $foto
 * @property string $endereco
 * @property string $bairro
 * @property string $cep
 * @property string complemento
 * @property string cidade
 * @property string uf
 *
 * @property Consulta[] $consultas
 */
class Paciente extends Pessoa
{

    public static function tableName()
    {
        return 'paciente';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->numero = date('Y') . '-'. $this->cpf . '-'. 'PA';
                $this->authkey = Yii::$app->getSecurity()->generateRandomString();
                $this->datacriacao = date('Y-m-d H:i:s');
                $this->dataalteracao = date('Y-m-d H:i:s');
                $this->senha = Yii::$app->security->generatePasswordHash($this->senha);
            } else {
                $this->dataalteracao = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultas()
    {
        return $this->hasMany(Consulta::className(), ['numeropaciente' => 'numero']);
    }
}
