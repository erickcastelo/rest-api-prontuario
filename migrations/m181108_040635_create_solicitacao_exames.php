<?php

use yii\db\Migration;

class m181108_040635_create_solicitacao_exames extends Migration
{
    public function up()
    {
        $this->createTable('solicitacaoexames', [
            'id' => $this->primaryKey(),
            'descricao' => $this->string(120),
            'valor' => $this->float(),
            'data' => $this->timestamp(),
            'autorizacaoempresa' => $this->string(1),
            'autorizacaoprofissional' => $this->string(1),
            'codconsulta' => $this->integer(),
            'codempresa' => $this->integer(),
            'datacriacao' => $this->timestamp(),
        ]);

        $this->addForeignKey('fk_codconsulta', 'solicitacaoexames', 'codconsulta', 'consulta', 'id');
        $this->addForeignKey('fk_codempresa', 'solicitacaoexames', 'codempresa', 'empresa', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_codconsulta', 'solicitacaoexames');
        $this->dropForeignKey('fk_codempresa', 'solicitacaoexames');
        $this->dropTable('solicitacaoexames');
    }
}
