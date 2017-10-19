<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exameimagem".
 *
 * @property integer $numero
 * @property string $nome
 *
 * @property Solicitacaoexames[] $solicitacaoexames
 */
class ExameImagem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exameimagem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero'], 'required'],
            [['numero'], 'integer'],
            [['nome'], 'string', 'max' => 90],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Numero',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitacaoexames()
    {
        return $this->hasMany(Solicitacaoexames::className(), ['numeroexameimagem' => 'numero']);
    }
}
