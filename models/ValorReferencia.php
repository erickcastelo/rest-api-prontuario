<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "valorreferencia".
 *
 * @property integer $id
 * @property string $faixaetaria
 * @property string $intervalo1
 * @property string $referencial
 * @property string $unidade
 * @property string $numexamelaboratorial
 *
 * @property Examelaboratorial $numexamelaboratorial0
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
            [['faixaetaria', 'intervalo1'], 'string', 'max' => 30],
            [['referencial'], 'string', 'max' => 20],
            [['unidade', 'numexamelaboratorial'], 'string', 'max' => 5],
            [['numexamelaboratorial'], 'exist', 'skipOnError' => true, 'targetClass' => ExameLaboratorial::className(), 'targetAttribute' => ['numexamelaboratorial' => 'numero']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'faixaetaria' => 'Faixaetaria',
            'intervalo1' => 'Intervalo1',
            'referencial' => 'Referencial',
            'unidade' => 'Unidade',
            'numexamelaboratorial' => 'Numeroexamelaboratorial',
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
