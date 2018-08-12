<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitacaoexamelab".
 *
 * @property integer $id
 * @property string $resultado
 * @property integer $codsolicitacao
 * @property string $numexamelab
 *
 * @property Examelaboratorial $numexamelab0
 * @property Solicitacaoexames $codsolicitacao0
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
            [['numexamelab'], 'string', 'max' => 5],
            [['numexamelab'], 'exist', 'skipOnError' => true, 'targetClass' => Examelaboratorial::className(), 'targetAttribute' => ['numexamelab' => 'numero']],
            [['codsolicitacao'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitacaoexames::className(), 'targetAttribute' => ['codsolicitacao' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
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
