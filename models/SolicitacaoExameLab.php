<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitacaoexamelab".
 *
 * @property integer $numero
 * @property string $resultado
 * @property integer $numerosolicitacao
 * @property string $numeroexamelab
 * @property string $datacriacao
 *
 * @property Examelaboratorial $numeroexamelab0
 * @property Solicitacaoexames $numerosolicitacao0
 */
class SolicitacaoExameLab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solicitacaoexamelab';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numerosolicitacao'], 'integer'],
            [['resultado'], 'string', 'max' => 120],
            [['numeroexamelab'], 'string', 'max' => 5],
            [['numeroexamelab'], 'exist', 'skipOnError' => true, 'targetClass' => Examelaboratorial::className(), 'targetAttribute' => ['numeroexamelab' => 'numero']],
            [['numerosolicitacao'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitacaoexames::className(), 'targetAttribute' => ['numerosolicitacao' => 'numero']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Numero',
            'resultado' => 'Resultado',
            'numerosolicitacao' => 'Numerosolicitacao',
            'numeroexamelab' => 'Numeroexamelab',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumeroexamelab0()
    {
        return $this->hasOne(Examelaboratorial::className(), ['numero' => 'numeroexamelab']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumerosolicitacao0()
    {
        return $this->hasOne(Solicitacaoexames::className(), ['numero' => 'numerosolicitacao']);
    }
}
