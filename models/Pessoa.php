<?php

namespace app\models;

use Yii;
use yii\validators\EmailValidator;
use yiibr\brvalidator\CpfValidator;

/**
 * This is the model class for table "pessoa".
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
 * @property string $foto
 * @property string $endereco
 * @property string $bairro
 * @property string $cep
 * @property string complemento
 * @property string cidade
 * @property string uf
 *
 * @property Pais $codpais0
 * @property Pessoa $responsavel0
 * @property Pessoa[] $pessoas
 */
class Pessoa extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'pessoa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'rg', 'cpf', 'nome', 'senha'], 'required'],
            [['datacriacao', 'datanascimento', 'dataalteracao'], 'safe'],
            [['codpais'], 'integer'],
            [['email', 'senha', 'responsavel', 'bairro', 'cidade'], 'string', 'max' => 60],
            [['uf'], 'string', 'max' => 2],
            [['rg'], 'string', 'max' => 13],
            [['cpf', 'fone'], 'string', 'max' => 11],
            [['cep'], 'string', 'max' => 8],
            [['foto'], 'string'],
            [['accesstoken', 'authkey', 'endereco', 'complemento'], 'string', 'max' => 120],
            [['nome'], 'string', 'max' => 90],
            [['codpais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['codpais' => 'codigo']],
            ['email', 'validationEmail'],
            ['cpf', CpfValidator::className(), 'message' => 'CPF não existe'],
//            [['responsavel'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoa::className(), 'targetAttribute' => ['responsavel' => 'email']],

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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
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
        ];
    }
}
