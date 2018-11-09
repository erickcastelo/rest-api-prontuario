<?php

use yii\db\Migration;

class m181108_015807_create_pais extends Migration
{

    public function up()
    {
        $this->createTable('pais', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(90)->notNull(),
            'sigla' => $this->string(3),
        ]);

        $this->generateCountrys();
    }

    public function down()
    {
        $this->dropTable('pais');
    }

    private function generateCountrys()
    {
        $countrys = [
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

        $this->batchInsert('pais', ['nome', 'sigla'], $countrys);
    }
}
