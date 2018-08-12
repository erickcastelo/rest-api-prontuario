<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitacaoexames".
 *
 * @property integer $id
 * @property string $descricao
 * @property double $valor
 * @property string $data
 * @property string $datacriacao
 * @property integer $codconsulta
 * @property string $codempresa
 * @property string $autorizacaoempresa
 * @property string $autorizacaoprofissional
 *
 * @property Consulta $codconsulta0
 * @property Empresa $codempresa0
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
            [['codconsulta'], 'integer'],
            [['descricao'], 'string', 'max' => 120],
            [['codempresa'], 'string', 'max' => 40],
            [['autorizacaoprofissional', 'autorizacaoempresa'], 'string', 'max' => 1],
//            [['numeroexamelaboratorial'], 'exist', 'skipOnError' => true, 'targetClass' => ExameLaboratorial::className(), 'targetAttribute' => ['numeroexamelaboratorial' => 'numero']],
            [['codconsulta'], 'exist', 'skipOnError' => true, 'targetClass' => Consulta::className(), 'targetAttribute' => ['codconsulta' => 'id']],
            [['cnpjcpfempresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['codempresa' => 'id']],
//            [['numeroexameimagem'], 'exist', 'skipOnError' => true, 'targetClass' => Exameimagem::className(), 'targetAttribute' => ['numeroexameimagem' => 'numero']],
        ];
    }


    public function lastNumber()
    {
        $query = SolicitacaoExames::find()->max('id');

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
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
