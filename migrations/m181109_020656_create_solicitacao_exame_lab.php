<?php

use yii\db\Migration;

class m181109_020656_create_solicitacao_exame_lab extends Migration
{
    public function up()
    {
        $this->createTable('solicitacaoexamelab', [
            'id' => $this->primaryKey(),
            'resultado' => $this->string(120),
            'codsolicitacao' => $this->integer(),
            'numexamelab' => $this->string(5)
        ]);

        $this->addForeignKey('fk_codsolicitacao', 'solicitacaoexamelab', 'codsolicitacao', 'solicitacaoexames', 'id');
        $this->addForeignKey('fk_numexamelab', 'solicitacaoexamelab', 'numexamelab', 'examelaboratorial', 'numero');
    }

    public function down()
    {
        $this->dropForeignKey('fk_codsolicitacao', 'solicitacaoexamelab');
        $this->dropForeignKey('fk_numexamelab', 'solicitacaoexamelab');
        $this->dropTable('solicitacaoexamelab');
    }
}
