<?php

use yii\db\Migration;

class m181108_030401_create_profissao extends Migration
{
    public function up()
    {
        $this->createTable('profissao', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(120)->notNull(),
            'sigla' => $this->string(10)
        ]);

        $this->generateProfission();
    }

    public function down()
    {
        echo "m181108_030401_create_profissao cannot be reverted.\n";

        return false;
    }

    private function generateProfission() {
        $profession = [
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
        $this->batchInsert('profissao', ['nome', 'sigla'], $profession);
    }
}
