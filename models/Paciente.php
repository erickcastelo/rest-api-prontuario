<?php

namespace app\models;

use Yii;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "paciente".
 *
 * @property string $email
 * @property string $rg
 * @property string $cpf
 * @property string $accesstoken
 * @property string $authkey
 * @property string $datacriacao
 * @property string $fone
 * @property string $datanascimento
 * @property string $nome
 * @property string $senha
 * @property integer $codpais
 * @property string $responsavel
 * @property string $numero
 *
 * @property Consulta[] $consultas
 */
class Paciente extends \yii\db\ActiveRecord
{
    public $confirmPassword;

    public static function tableName()
    {
        return 'paciente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'rg', 'cpf', 'fone', 'nome', 'senha', 'numero'], 'required'],
            [['datacriacao', 'datanascimento'], 'safe'],
            [['codpais'], 'integer'],
            [['email', 'senha', 'responsavel'], 'string', 'max' => 60],
            [['rg'], 'string', 'max' => 13],
            [['cpf'], 'string', 'max' => 11],
            [['accesstoken', 'authkey'], 'string', 'max' => 120],
            [['fone'], 'string', 'max' => 9],
            [['nome'], 'string', 'max' => 90],
            [['numero'], 'string', 'max' => 20],
            [['email', 'rg', 'cpf'], 'unique'],
            ['email', 'validationEmail'],
            ['confirmPassword', 'confirmationPassword']
        ];
    }

    public function validationEmail($attribute, $params)
    {
        $email = $this->email;
        $validator = new EmailValidator();

        if (!$validator->validate($email, $error)){
            $this->addError($attribute, 'Email é inválido');
        }
    }

    public function confirmationPassword($attribute, $params)
    {
        $password = $this->senha;
        $confirmPassword = $this->confirmPassword;

        if ($password !== $confirmPassword){
            $this->addError($attribute, 'Senhas não conferem');
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'rg' => 'Rg',
            'cpf' => 'Cpf',
            'accesstoken' => 'Accesstoken',
            'authkey' => 'Authkey',
            'datacriacao' => 'Datacriacao',
            'fone' => 'Fone',
            'datanascimento' => 'Datanascimento',
            'nome' => 'Nome',
            'senha' => 'Senha',
            'codpais' => 'Codpais',
            'responsavel' => 'Responsavel',
            'numero' => 'Numero',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultas()
    {
        return $this->hasMany(Consulta::className(), ['numeropaciente' => 'numero']);
    }
}
