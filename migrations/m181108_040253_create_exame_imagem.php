<?php

use yii\db\Migration;

class m181108_040253_create_exame_imagem extends Migration
{
    public function up()
    {
        $this->createTable('exameimagem', [
            'id' => $this->primaryKey(),
            'numero' => $this->integer()->notNull(),
            'nome' => $this->string(90)
        ]);
    }

    public function down()
    {
        $this->dropTable('exameimagem');
    }
}
