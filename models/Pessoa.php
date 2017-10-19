<?php

namespace app\models;

use Yii;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "pessoa".
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
            [['email', 'rg', 'cpf', 'fone', 'nome', 'senha'], 'required'],
            [['datacriacao', 'datanascimento'], 'safe'],
            [['codpais'], 'integer'],
            [['email', 'senha', 'responsavel'], 'string', 'max' => 60],
            [['rg'], 'string', 'max' => 13],
            [['cpf'], 'string', 'max' => 11],
            [['accesstoken', 'authkey'], 'string', 'max' => 120],
            [['fone'], 'string', 'max' => 9],
            [['nome'], 'string', 'max' => 90],
            [['codpais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['codpais' => 'codigo']],
            [['responsavel'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoa::className(), 'targetAttribute' => ['responsavel' => 'email']],

        ];
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodpais0()
    {
        return $this->hasOne(Pais::className(), ['codigo' => 'codpais']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsavel0()
    {
        return $this->hasOne(Pessoa::className(), ['email' => 'responsavel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPessoas()
    {
        return $this->hasMany(Pessoa::className(), ['responsavel' => 'email']);
    }
}
