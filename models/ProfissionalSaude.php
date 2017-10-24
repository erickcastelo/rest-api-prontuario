<?php

namespace app\models;

use Yii;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "profissionalsaude".
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
 * @property string $emailprofissional
 * @property string $registro
 * @property integer $codprofissao
 * @property string $foto
 *
 * @property Consulta[] $consultas
 * @property Profissao $codprofissao0
 */
class ProfissionalSaude extends \yii\db\ActiveRecord
{

    public $confirmPassword;
    public $fotoFile;

    public static function tableName()
    {
        return 'profissionalsaude';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'rg', 'cpf', 'fone', 'nome', 'senha', 'numero'], 'required'],
            [['datacriacao', 'datanascimento'], 'safe'],
            [['codpais', 'codprofissao'], 'integer'],
            [['email', 'senha', 'responsavel', 'emailprofissional'], 'string', 'max' => 60],
            [['rg'], 'string', 'max' => 13],
            [['cpf'], 'string', 'max' => 11],
            [['foto'], 'string'],
            [['accesstoken', 'authkey'], 'string', 'max' => 120],
            [['fone'], 'string', 'max' => 9],
            [['nome', 'registro'], 'string', 'max' => 90],
            [['numero'], 'string', 'max' => 40],
            [['fotoFile'], 'file'],
            [['codprofissao'], 'exist', 'skipOnError' => true, 'targetClass' => Profissao::className(), 'targetAttribute' => ['codprofissao' => 'codigo']],
            [['email', 'rg', 'cpf'], 'unique'],
            ['email', 'email', 'message' => 'Email inválido!'],
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
            'emailprofissional' => 'Emailprofissional',
            'registro' => 'Registro',
            'codprofissao' => 'Codprofissao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultas()
    {
        return $this->hasMany(Consulta::className(), ['numeroprofissionalsaude' => 'numero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfissao()
    {
        return $this->hasOne(Profissao::className(), ['codigo' => 'codprofissao']);
    }

    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['codigo' => 'codpais']);
    }
}
