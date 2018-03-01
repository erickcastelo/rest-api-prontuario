<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitacaoexameimagem".
 *
 * @property integer $numero
 * @property string $laudo
 * @property integer $numerosolicitacao
 * @property integer $numeroimagem
 *
 * @property Exameimagem $numeroimagem0
 * @property Solicitacaoexames $numerosolicitacao0
 */
class SolicitacaoExameImagem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solicitacaoexameimagem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numerosolicitacao', 'numeroimagem'], 'integer'],
            [['laudo'], 'string', 'max' => 120],
            [['numeroimagem'], 'exist', 'skipOnError' => true, 'targetClass' => Exameimagem::className(), 'targetAttribute' => ['numeroimagem' => 'numero']],
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
            'laudo' => 'Laudo',
            'numerosolicitacao' => 'Numerosolicitacao',
            'numeroimagem' => 'Numeroimagem',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumeroimagem0()
    {
        return $this->hasOne(Exameimagem::className(), ['numero' => 'numeroimagem']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumerosolicitacao0()
    {
        return $this->hasOne(Solicitacaoexames::className(), ['numero' => 'numerosolicitacao']);
    }
}
