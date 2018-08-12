<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitacaoexameimagem".
 *
 * @property integer $id
 * @property string $laudo
 * @property integer $codsolicitacao
 * @property integer $codimagem
 *
 * @property Exameimagem $codimagem0
 * @property Solicitacaoexames $codsolicitacao0
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
            [['codsolicitacao', 'codimagem'], 'integer'],
            [['laudo'], 'string', 'max' => 120],
            [['codimagem'], 'exist', 'skipOnError' => true, 'targetClass' => Exameimagem::className(), 'targetAttribute' => ['codimagem' => 'id']],
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
