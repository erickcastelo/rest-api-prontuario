<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consulta".
 *
 * @property integer $id
 * @property string $datacriacao
 * @property string $dataconsulta
 * @property string $situacao
 * @property string codpaciente
 * @property string codprofissionalsaude
 * @property string $descricao
 *
 * @property Paciente $numeropaciente0
 * @property ProfissionalSaude $numeroprofissionalsaude0
 */
class Consulta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consulta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datacriacao'], 'required'],
            [['datacriacao', 'dataconsulta'], 'safe'],
            [['codpaciente', 'codprofissionalsaude'], 'integer'],
            [['situacao'], 'string', 'max' => 1],
            [['descricao'], 'string', 'max' => 120],
            [['numeropaciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['numeropaciente' => 'numero']],
            [['numeroprofissionalsaude'], 'exist', 'skipOnError' => true, 'targetClass' => ProfissionalSaude::className(), 'targetAttribute' => ['numeroprofissionalsaude' => 'numero']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'datacriacao' => 'Datacriacao',
            'dataconsulta' => 'Dataconsulta',
            'situacao' => 'Situacao',
            'numeropaciente' => 'Numeropaciente',
            'numeroprofissionalsaude' => 'Numeroprofissionalsaude',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['numero' => 'numeropaciente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfissional()
    {
        return $this->hasOne(ProfissionalSaude::className(), ['numero' => 'numeroprofissionalsaude']);
    }

//    public function fields()
//    {
//        return [
//            'situacao' => function(Consulta $model){
//               return $model->situacao === 'p' ? 'Pendente' : 'Aprovada';
//            }
//        ];
//    }
}
