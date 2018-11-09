<?php

use yii\db\Migration;

class m181108_033404_create_consulta extends Migration
{
    public function up()
    {
        $this->createTable('consulta', [
            'id' => $this->primaryKey(),
            'datacriacao' => $this->timestamp()->notNull(),
            'dataconsulta' => $this->timestamp()->notNull(),
            'descricao' => $this->string(120),
            'situacao' => $this->string(1),
            'codpaciente' => $this->integer(),
            'codprofissionalsaude' => $this->integer(),
        ]);

        $this->addForeignKey('fk_cod_paciente', 'consulta', 'codpaciente', 'paciente', 'id');
        $this->addForeignKey('fk_cod_profissional_saude', 'consulta', 'codprofissionalsaude', 'profissionalsaude', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_cod_paciente', 'consulta');
        $this->dropForeignKey('fk_cod_profissional_saude', 'consulta');
        $this->dropTable('consulta');
    }
}
