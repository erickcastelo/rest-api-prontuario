<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "valorreferencia".
 *
 * @property integer $codigo
 * @property string $faixaetaria
 * @property string $intervalo1
 * @property string $referencial
 * @property string $unidade
 * @property integer $numeroexamelaboratorial
 *
 * @property Examelaboratorial $numeroexamelaboratorial0
 */
class ValorReferencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'valorreferencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroexamelaboratorial'], 'integer'],
            [['faixaetaria', 'intervalo1'], 'string', 'max' => 30],
            [['referencial'], 'string', 'max' => 20],
            [['unidade'], 'string', 'max' => 5],
            [['numeroexamelaboratorial'], 'exist', 'skipOnError' => true, 'targetClass' => ExameLaboratorial::className(), 'targetAttribute' => ['numeroexamelaboratorial' => 'numero']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'faixaetaria' => 'Faixaetaria',
            'intervalo1' => 'Intervalo1',
            'referencial' => 'Referencial',
            'unidade' => 'Unidade',
            'numeroexamelaboratorial' => 'Numeroexamelaboratorial',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNumeroexamelaboratorial0()
    {
        return $this->hasOne(Examelaboratorial::className(), ['numero' => 'numeroexamelaboratorial']);
    }
}
