<?php
/**
 * Created by PhpStorm.
 * User: erick
 * Date: 19/09/17
 * Time: 09:15
 */

namespace app\models;


class GeradorTabelas
{
    public function geradorPais()
    {;

        $paises = [
            0 => [
                'nome' => 'Brasil',
                'sigla' => 'BRA',
            ],
            1 => [
                'nome' => 'Argentina',
                'sigla' => 'ARG',
            ],
            2 => [
                'nome' => 'Estados Unidos',
                'sigla' => 'USA'
            ],
            3 => [
                'nome' => 'Uruguai',
                'sigla' => 'URA'
            ],
            4 => [
                'nome' => 'Irlanda',
                'sigla' => 'IRL'
            ]
        ];

        \Yii::$app->db
            ->createCommand()
            ->batchInsert(Pais::tableName(), ['nome', 'sigla'], $paises)
            ->execute();
    }

    public function geradorProfissao()
    {
        $profissoes = [
            0 => [
                'nome' => 'Médico',
                'sigla' => 'MED'
            ],
            1 => [
                'nome' => 'Enfermagem',
                'sigla' => 'ENF'
            ],
            2 => [
                'nome' => 'Dentista',
                'sigla' => 'DEN'
            ],
            3 => [
                'nome' => 'Ordopedista',
                'sigla' => 'ORD'
            ],
            4 => [
                'nome' => 'Ginecologista',
                'sigla' => 'GIN'
            ],
        ];

        \Yii::$app->db
            ->createCommand()
            ->batchInsert(Profissao::tableName(), ['nome', 'sigla'], $profissoes)
            ->execute();
    }

    public function classificacao()
    {
        $classificacoes = [
            0 => [
                'nome' => 'HOMENS',
            ],
            1 => [
                'nome' => 'MULHERES',
            ],
            2 => [
                'nome' => 'CRIANÇAS',
            ],
            3 => [
                'nome' => 'ACIMA DE 70 ANOS',
            ],
            4 => [
                'nome' => 'ADULTOS',
            ],
            5 => [
                'nome' => 'CRIANÇAS (MENORES DE 8 ANOS)',
            ],
        ];

        \Yii::$app->db
            ->createCommand()
            ->batchInsert(Classificacao::tableName(), ['nome'], $classificacoes)
            ->execute();
    }

    public function gerarHemograma()
    {
        $model = new ExameLaboratorial();
        $model->numero = '1';
        $model->nome = 'HEMOGRAMA COMPLETO';
        $model->save();

        $classficacoes = [
            0 => [
                'numero' => '1.1',
                'nome' => 'HEMACIAS',
                'possui' => '1',
            ],
            1 => [
                'numero' => '1.2',
                'nome' => 'HEMOGLOBINA',
                'possui' => '1',
            ],
            2 => [
                'numero' => '1.3',
                'nome' => 'HEMOTOCRITO',
                'possui' => '1',
            ],
            3 => [
                'numero' => '1.4',
                'nome' => 'VCM',
                'possui' => '1',
            ],
            4 => [
                'numero' => '1.5',
                'nome' => 'HCM',
                'possui' => '1',
            ],
            5 => [
                'numero' => '1.6',
                'nome' => 'CHCM',
                'possui' => '1',
            ],
            6 => [
                'numero' => '1.7',
                'nome' => 'RDW',
                'possui' => '1',
            ]
        ];

        \Yii::$app->db
            ->createCommand()
            ->batchInsert(ExameLaboratorial::tableName(), ['numero','nome', 'possui'], $classficacoes)
            ->execute();
    }

    public function gerarValoresReferenciaHemograma()
    {
        $valores = [
            0 => [
                'faixaetaria' => 'HOMENS',
                'intervalo1' => '4.50a6.10',
                'unidade' => 'milhoes/mm3',
                'numeroexamelaboratorial' => '1.1'
            ],
            1 => [
                'faixaetaria' => 'MULHERES',
                'intervalo1' => '4.00a5.40',
                'unidade' => 'milhoes/mm3',
                'numeroexamelaboratorial' => '1.1'
            ],
            2 => [
                'faixaetaria' => 'CRIANÇAS',
                'intervalo1' => '4.07a5.37',
                'unidade' => 'milhoes/mm3',
                'numeroexamelaboratorial' => '1.1'
            ],
            3 => [
                'faixaetaria' => 'ACIMA DE 70 ANOS',
                'intervalo1' => '3.90a5.36',
                'unidade' => 'milhoes/mm3',
                'numeroexamelaboratorial' => '1.1'
            ],
            4 => [
                'faixaetaria' => 'HOMENS',
                'intervalo1' => '13.00a16.50',
                'unidade' => 'g/dL',
                'numeroexamelaboratorial' => '1.2'
            ],
            5 => [
                'faixaetaria' => 'MULHERES',
                'intervalo1' => '12.00a15.80',
                'unidade' => 'g/dL',
                'numeroexamelaboratorial' => '1.2'
            ],
            6 => [
                'faixaetaria' => 'CRIANÇAS',
                'intervalo1' => '10.50a14.00',
                'unidade' => 'g/dL',
                'numeroexamelaboratorial' => '1.2'
            ],
            7 => [
                'faixaetaria' => 'ACIMA DE 70 ANOS',
                'intervalo1' => '11.50a15.10',
                'unidade' => 'g/dL',
                'numeroexamelaboratorial' => '1.2'
            ],
            8 => [
                'faixaetaria' => 'HOMENS',
                'intervalo1' => '36.00a54.00',
                'unidade' => '%',
                'numeroexamelaboratorial' => '1.3'
            ],
            9 => [
                'faixaetaria' => 'MULHERES',
                'intervalo1' => '33.00a47.80',
                'unidade' => '%',
                'numeroexamelaboratorial' => '1.3'
            ],
            10 => [
                'faixaetaria' => 'CRIANÇAS',
                'intervalo1' => '30.00a44.50',
                'unidade' => '%',
                'numeroexamelaboratorial' => '1.3'
            ],
            11 => [
                'faixaetaria' => 'ACIMA DE 70 ANOS',
                'intervalo1' => '33.00a46.00',
                'unidade' => '%',
                'numeroexamelaboratorial' => '1.3'
            ],
            12 => [
                'faixaetaria' => 'HOMENS',
                'intervalo1' => '80.00a98.00',
                'unidade' => 'fl',
                'numeroexamelaboratorial' => '1.4'
            ],
            13 => [
                'faixaetaria' => 'MULHERES',
                'intervalo1' => '80.00a98.00',
                'unidade' => 'fl',
                'numeroexamelaboratorial' => '1.4'
            ],
            14 => [
                'faixaetaria' => 'CRIANÇAS',
                'intervalo1' => '70.00a86.00',
                'unidade' => 'fl',
                'numeroexamelaboratorial' => '1.4'
            ],
            15 => [
                'faixaetaria' => 'ACIMA DE 70 ANOS',
                'intervalo1' => '80.00a98.00',
                'unidade' => 'fl',
                'numeroexamelaboratorial' => '1.4'
            ],
            16 => [
                'faixaetaria' => 'HOMENS',
                'intervalo1' => '26.00a32.90',
                'unidade' => 'pg',
                'numeroexamelaboratorial' => '1.5'
            ],
            17 => [
                'faixaetaria' => 'MULHERES',
                'intervalo1' => '26.00a32.60',
                'unidade' => 'pg',
                'numeroexamelaboratorial' => '1.5'
            ],
            18 => [
                'faixaetaria' => 'CRIANÇAS',
                'intervalo1' => '23.20a31.70',
                'unidade' => 'pg',
                'numeroexamelaboratorial' => '1.5'
            ],
            19 => [
                'faixaetaria' => 'ACIMA DE 70 ANOS',
                'intervalo1' => '27.00a31.00',
                'unidade' => 'pg',
                'numeroexamelaboratorial' => '1.5'
            ],
            20 => [
                'faixaetaria' => 'HOMENS',
                'intervalo1' => '30.00a36.50',
                'unidade' => 'g/dl',
                'numeroexamelaboratorial' => '1.6'
            ],
            21 => [
                'faixaetaria' => 'MULHERES',
                'intervalo1' => '30.00a36.50',
                'unidade' => 'g/dl',
                'numeroexamelaboratorial' => '1.6'
            ],
            22 => [
                'faixaetaria' => 'CRIANÇAS',
                'intervalo1' => '30.00a36.50',
                'unidade' => 'g/dl',
                'numeroexamelaboratorial' => '1.6'
            ],
            23 => [
                'faixaetaria' => 'ACIMA DE 70 ANOS',
                'intervalo1' => '30.00a36.50',
                'unidade' => 'g/dl',
                'numeroexamelaboratorial' => '1.6'
            ],
            24 => [
                'faixaetaria' => 'HOMENS',
                'intervalo1' => '11.00a16.00',
                'unidade' => '%',
                'numeroexamelaboratorial' => '1.7'
            ],
            25 => [
                'faixaetaria' => 'MULHERES',
                'intervalo1' => '11.00a16.00',
                'unidade' => '%',
                'numeroexamelaboratorial' => '1.7'
            ],
            26 => [
                'faixaetaria' => 'CRIANÇAS',
                'intervalo1' => '11.00a16.00',
                'unidade' => '%',
                'numeroexamelaboratorial' => '1.7'
            ],
            27 => [
                'faixaetaria' => 'ACIMA DE 70 ANOS',
                'intervalo1' => '11.00a16.00',
                'unidade' => '%',
                'numeroexamelaboratorial' => '1.7'
            ],
        ];

        \Yii::$app->db
            ->createCommand()
            ->batchInsert(ValorReferencia::tableName(), ['faixaetaria','intervalo1', 'unidade', 'numeroexamelaboratorial'], $valores)
            ->execute();
    }

    public function gerarGlicose()
    {
        $model = new ExameLaboratorial();
        $model->numero = '2';
        $model->nome = 'GLICOSE';
        $model->save();

        $glicoses = [
            0 => [
                'numero' => '2.1',
                'nome' => 'NORMAL',
                'possui' => '2'
            ],
            1 => [
                'numero' => '2.2',
                'nome' => 'INTOLERANCIA GLICOSE JEJUM',
                'possui' => '2'
            ],
            2 => [
                'numero' => '2.3',
                'nome' => 'DIABETES MELLITUS',
                'possui' => '2'
            ],
        ];

        \Yii::$app->db
            ->createCommand()
            ->batchInsert(ExameLaboratorial::tableName(), ['numero','nome', 'possui'], $glicoses)
            ->execute();
    }

    public function gerarValoresReferenciaGlicose()
    {
        $valores = [
            0 => [
                'faixaetaria' => 'NORMAL',
                'intervalo1' => '70.00a99.00',
                'unidade' => 'mg/dL',
                'numeroexamelaboratorial' => '2'
            ],
            1 => [
                'faixaetaria' => 'INTOLERANCIA GLICOSE JEJUM',
                'intervalo1' => '100.00a125.00',
                'unidade' => 'mg/dL',
                'numeroexamelaboratorial' => '2'
            ],
            2 => [
                'faixaetaria' => 'DIABETES MELLITUS',
                'intervalo1' => '>126',
                'unidade' => 'mg/dL',
                'numeroexamelaboratorial' => '2'
            ]
        ];

        \Yii::$app->db
            ->createCommand()
            ->batchInsert(ValorReferencia::tableName(), ['faixaetaria','intervalo1', 'unidade', 'numeroexamelaboratorial'], $valores)
            ->execute();
    }
}