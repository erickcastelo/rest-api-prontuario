<?php

use yii\db\Migration;

class m181109_022655_create_imagem_solicitacoes_exame extends Migration
{

    public function up()
    {
        $this->createTable('imagem_solicitacoes_exame', [
            'id' => $this->primaryKey(),
            'codsolicitacao' => $this->integer(),
            'codimagem' => $this->integer(),
        ]);

        $this->addForeignKey('fk_codsolicitacao', 'imagem_solicitacoes_exame', 'codsolicitacao', 'solicitacaoexames', 'id');
        $this->addForeignKey('fk_codimagem', 'imagem_solicitacoes_exame', 'codimagem', 'exameimagem', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_codsolicitacao', 'imagem_solicitacoes_exame');
        $this->dropForeignKey('fk_codimagem', 'imagem_solicitacoes_exame');
        $this->dropTable('imagem_solicitacoes_exame');
    }
}
