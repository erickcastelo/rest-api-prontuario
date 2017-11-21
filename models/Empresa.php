<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "empresa".
 *
 * @property string $cnpj
 * @property string $cpf
 * @property string $rg
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property string $fantasia
 * @property string $fone
 * @property string $endereco
 * @property string $bairro
 * @property string $servicolaboratorial
 * @property string $servicoimagem
 * @property string $authkey
 * @property string $datacriacao
 * @property string $accesstoken
 * @property string $datanascimento
 * @property integer $codpais
 * @property string $responsavel
 * @property string $foto
 *
 * @property Solicitacaoexames[] $solicitacaoexames
 */
class Empresa extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'endereco'], 'required'],
            [['cpf', 'cnpj'], 'string', 'max' => 15],
            [['datacriacao', 'datanascimento'], 'safe'],
            [['cpf'], 'string', 'max' => 11],
            [['rg'], 'string', 'max' => 13],
            [['email', 'senha', 'responsavel', 'bairro'], 'string', 'max' => 60],
            [['nome', 'fantasia'], 'string', 'max' => 90],
            [['fone'], 'string', 'max' => 11],
            [['accesstoken', 'authkey', 'endereco'], 'string', 'max' => 120],
            [['servicoLaboratorial', 'servicoImagem'], 'string', 'max' => 30],
            [['endereco', 'email', 'senha'], 'string', 'max' => 60],
            [['bairro'], 'string', 'max' => 45],
            [['foto'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cnpjcpf' => 'Cnpjcpf',
            'nome' => 'Nome',
            'fantasia' => 'Fantasia',
            'fone' => 'Fone',
            'endereco' => 'Endereco',
            'bairro' => 'Bairro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitacaoexames()
    {
        return $this->hasMany(SolicitacaoExames::className(), ['cnpjcpfempresa' => 'cnpjcpf']);
    }

    public static function findByUsername($username)
    {
        $user = Empresa::find()
            ->where(['email' => $username])
            ->one();

        if ($user){
            return new static($user);
        }
    }

    public function validatePassword($password)
    {
        return $this->senha === $password;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        $user = Empresa::find()
            ->where(['email' => $id])
            ->one();

        if ($user){
            return new static($user);
        }
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = Empresa::find()
            ->where(['authkey' => $token])
            ->one();

        if ($user){
            return new static($user);
        }

        return null;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->cnpjcpf;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->authkey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->authkey === $authKey;
    }

    public function getLogin()
    {
        return $this->email;
    }
}
