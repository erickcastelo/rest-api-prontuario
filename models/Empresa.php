<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "empresa".
 *
 * @property integer $id
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
 * @property string $tipoempresa
 *
 * @property Solicitacaoexames[] $solicitacaoexames
 */
class Empresa extends Pessoa
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitacaoexames()
    {
        return $this->hasMany(SolicitacaoExames::className(), ['cnpjcpfempresa' => 'cnpjcpf']);
    }
}
