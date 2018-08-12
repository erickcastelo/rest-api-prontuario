<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profissao".
 *
 * @property integer $id
 * @property string $nome
 * @property string $sigla
 *
 * @property Profissionalsaude[] $profissionalsaudes
 */
class Profissao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profissao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 120],
            [['sigla'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfissionalsaudes()
    {
        return $this->hasMany(Profissionalsaude::className(), ['codprofissao' => 'id']);
    }

    public function lastCode()
    {
        $codigo = Profissao::find()->max('id');

        return $codigo;
    }
}
