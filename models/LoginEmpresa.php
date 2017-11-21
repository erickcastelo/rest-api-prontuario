<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 16/11/17
 * Time: 12:12
 */

namespace app\models;
use Yii;
use yii\base\Model;

/**
 * LoginFormEmpresa is the model behind the login form.
 *
 * @property Empresa|null $user This property is read-only.
 *
 */

class LoginEmpresa extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;
    private $_user = true;
    public $tipoPessoa;

    public $tipoSessao;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            [['tipoPessoa', 'tipoSessao'], 'integer'],
            // rememberMe must be a boolean value
            [['rememberMe'],'boolean'],
            [['email'],'email'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
//            ['password', 'validaPessoa'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Login',
            'password' => 'Senha'
        ];
    }

//    public function validaPessoa($attribute, $params)
//    {
//        $tipoPessoa = $this->tipoPessoa;
//
//        if ($tipoPessoa != $this->tipoSessao){
//            $this->addError($attribute, 'Você não estar autorizado');
//        }
//    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuário ou senha incorretos.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === true) {
            $this->_user = Empresa::findByUsername($this->email);
        }

        return $this->_user;
    }
}