<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitacaoexames".
 *
 * @property integer $numero
 * @property string $descricao
 * @property double $valor
 * @property string $data
 * @property string $datacriacao
 * @property integer $codigoconsulta
 * @property string $numeroempresa
 * @property string $autorizacaoempresa
 * @property string $autorizacaoprofissional
 *
 * @property Consulta $codigoconsulta0
 * @property Empresa $numero0
 */
class SolicitacaoExames extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solicitacaoexames';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor'], 'number'],
            [['data', 'datacriacao'], 'safe'],
            [['codigoconsulta'], 'integer'],
            [['descricao'], 'string', 'max' => 120],
            [['numeroempresa'], 'string', 'max' => 40],
            [['autorizacaoprofissional', 'autorizacaoempresa'], 'string', 'max' => 1],
//            [['numeroexamelaboratorial'], 'exist', 'skipOnError' => true, 'targetClass' => ExameLaboratorial::className(), 'targetAttribute' => ['numeroexamelaboratorial' => 'numero']],
            [['codigoconsulta'], 'exist', 'skipOnError' => true, 'targetClass' => Consulta::className(), 'targetAttribute' => ['codigoconsulta' => 'codigo']],
            [['cnpjcpfempresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['numeroempresa' => 'numero']],
//            [['numeroexameimagem'], 'exist', 'skipOnError' => true, 'targetClass' => Exameimagem::className(), 'targetAttribute' => ['numeroexameimagem' => 'numero']],
        ];
    }


    public function lastNumber()
    {
        $query = SolicitacaoExames::find()->max('numero');

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Numero',
            'descricao' => 'Descricao',
            'valor' => 'Valor',
            'datacriacao' => 'Datacriacao',
            'codigoconsulta' => 'Codigoconsulta',
            'numeroexameimagem' => 'Numeroexameimagem',
            'numeroexamelaboratorial' => 'Numeroclassificacao',
            'cnpjcpfempresa' => 'Cnpjcpfempresa',
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
    public function getCodigoconsulta0()
    {
        return $this->hasOne(Consulta::className(), ['codigo' => 'codigoconsulta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCnpjcpfempresa0()
    {
        return $this->hasOne(Empresa::className(), ['cnpjcpf' => 'cnpjcpfempresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getNumeroexameimagem0()
//    {
//        return $this->hasOne(Exameimagem::className(), ['numero' => 'numeroexameimagem']);
//    }
}
