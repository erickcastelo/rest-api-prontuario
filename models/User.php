<?php

namespace app\models;

use Yii;

class User extends Pessoa implements \yii\web\IdentityInterface
{
    public $numero;
    public $cpf;
    public $rg;
    public $nome;
    public $login;
    public $senha;
    public $datanascimento;
    public $datacriacao;
    public $fone;
    public $numerotipo;
    public $responsavel;
    //public $username;
    //public $password;
    public $authkey;
    public $accesstoken;
    public $password_hash;

    /*private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = Pessoa::find()
            ->where(['email' => $id])
            ->one();

        if ($user){
            return new static($user);
        }

        //return parent::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }*/

        $user = Pessoa::find()
            ->where(['authkey' => $token])
            ->one();

        if ($user){
            return new static($user);
        }

        return null;
        //var_dump(static::findOne(['authkey' => $token])->); die();
        //return static::findOne(['authkey' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = Pessoa::find()
            ->where(['email' => $username])
            ->one();

        if ($user){
            return new static($user);
        }

        //return parent::findOne(['login' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->numero;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authkey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authkey === $authKey;
    }

    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->senha);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}
