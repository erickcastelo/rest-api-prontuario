<?php

namespace app\models;

use Yii;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "profissionalsaude".
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
 * @property string $emailprofissional
 * @property string $registro
 * @property integer $codprofissao
 * @property string $foto
 * @property string $endereco
 * @property string $bairro
 * @property string $cep
 * @property string complemento
 * @property string cidade
 * @property string uf
 *
 * @property Consulta[] $consultas
 * @property Profissao $codprofissao0
 */
class ProfissionalSaude extends Pessoa
{

    public static function tableName()
    {
        return 'profissionalsaude';
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
