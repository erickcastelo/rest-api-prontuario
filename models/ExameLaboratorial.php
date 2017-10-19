<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "examelaboratorial".
 *
 * @property integer $numero
 * @property string $nome
 * @property integer $numeroclassificacao
 * @property integer $possui
 * @property string $resultado
 *
 * @property Classificacao $numeroclassificacao0
 * @property ExameLaboratorial $possui0
 * @property ExameLaboratorial[] $exameLaboratorials
 * @property Solicitacaoexames[] $solicitacaoexames
 */
class ExameLaboratorial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'examelaboratorial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero', 'nome'], 'required'],
            [['nome'], 'string', 'max' => 60],
            [['numero', 'possui'], 'string', 'max' => 5],
            [['resultado'], 'string', 'max' => 90],
            [['numeroclassificacao'], 'integer'],
            [['numeroclassificacao'], 'exist', 'skipOnError' => true, 'targetClass' => Classificacao::className(), 'targetAttribute' => ['numeroclassificacao' => 'numero']],
            [['possui'], 'exist', 'skipOnError' => true, 'targetClass' => ExameLaboratorial::className(), 'targetAttribute' => ['possui' => 'numero']],
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
            'numeroclassificacao' => 'Numeroclassificacao',
            'possui' => 'Possui',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumeroclassificacao0()
    {
        return $this->hasOne(Classificacao::className(), ['numero' => 'numeroclassificacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPossui0()
    {
        return $this->hasOne(ExameLaboratorial::className(), ['numero' => 'possui']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExameLaboratorials()
    {
        return $this->hasMany(ExameLaboratorial::className(), ['possui' => 'numero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitacaoexames()
    {
        return $this->hasMany(Solicitacaoexames::className(), ['numeroexamelabotarorial' => 'numero']);
    }
}
