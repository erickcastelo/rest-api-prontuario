<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "classificacao".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property Examelaboratorial[] $examelaboratorials
 */
class Classificacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classificacao';
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
            'id' => 'Id',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamelaboratorials()
    {
        return $this->hasMany(Examelaboratorial::className(), ['numeroclassificacao' => 'id']);
    }

    public function lastNumber()
    {
        $query = Classificacao::find()
            ->select('id')
            ->one();

        return $query;
    }
}
