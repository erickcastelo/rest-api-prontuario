<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property string $cnpjcpf
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property string $fantasia
 * @property string $fone
 * @property string $endereco
 * @property string $bairro
 * @property string $servicoLaboratorial
 * @property string $servicoImagem
 *
 * @property Solicitacaoexames[] $solicitacaoexames
 */
class Empresa extends \yii\db\ActiveRecord
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
            [['cnpjcpf', 'nome', 'endereco'], 'required'],
            [['cnpjcpf'], 'string', 'max' => 15],
            [['nome', 'fantasia'], 'string', 'max' => 90],
            [['fone'], 'string', 'max' => 11],
            [['servicoLaboratorial', 'servicoImagem'], 'string', 'max' => 30],
            [['endereco', 'email', 'senha'], 'string', 'max' => 60],
            [['bairro'], 'string', 'max' => 45],
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
}
