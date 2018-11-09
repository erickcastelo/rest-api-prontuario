<?php

use yii\db\Migration;

class m181109_021815_create_solicitacao_exame_imagem extends Migration
{
    public function up()
    {
        $this->createTable('solicitacaoexameimagem', [
            'id' => $this->primaryKey(),
            'laudo' => $this->string(120),
            'codsolicitacao' => $this->integer(),
            'codimagem' => $this->integer(),
        ]);

        $this->addForeignKey('fk_codsolicitacao', 'solicitacaoexameimagem', 'codsolicitacao', 'solicitacaoexames', 'id');
        $this->addForeignKey('fk_codimagem', 'solicitacaoexameimagem', 'codimagem', 'exameimagem', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_codsolicitacao', 'solicitacaoexameimagem');
        $this->dropForeignKey('fk_codimagem', 'solicitacaoexameimagem');
        $this->dropTable('solicitacaoexameimagem');
    }
}
