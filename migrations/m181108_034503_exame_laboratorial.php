<?php

use yii\db\Migration;

class m181108_034503_exame_laboratorial extends Migration
{
    public function up()
    {
        $this->createTable('examelaboratorial', [
            'numero' => $this->string(5),
            'nome' => $this->string(60)->notNull(),
            'possui' => $this->string(5),
            'observacao' => $this->string(120),
            'resultado' => $this->string(60),
        ]);

        $this->addPrimaryKey('pk_numero', 'examelaboratorial','numero');
        $this->addForeignKey('fk_possui', 'examelaboratorial', 'possui', 'examelaboratorial', 'numero');
    }

    public function down()
    {
        $this->dropForeignKey('fk_possui', 'examelaboratorial');
        $this->dropTable('examelaboratorial');
    }
}
