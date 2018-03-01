<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pais".
 *
 * @property integer $codigo
 * @property string $nome
 * * @property string $sigla
 *
 * @property Pessoa[] $pessoas
 */
class Pais extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 90],
            [['sigla'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPessoas()
    {
        return $this->hasMany(Pessoa::className(), ['codpais' => 'codigo']);
    }

    //último código
    public function lastCode()
    {
        $codigo = Pais::find()->max('codigo');

        return $codigo;
    }
}
