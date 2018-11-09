<?php

use yii\db\Migration;

class m181108_025320_create_paciente extends Migration
{
    public function up()
    {
        $this->execute('
            create table paciente(
                id serial not null,
                numero varchar(20) not null,
                primary key(id)
            )inherits (pessoa)
        ');

        $this->addForeignKey('fk_cod_pais', 'paciente', 'codpais', 'pais', 'id');
        $this->addForeignKey('fk_responsavel', 'paciente', 'responsavel', 'pessoa', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_cod_pais', 'paciente');
        $this->dropForeignKey('fk_responsavel', 'paciente');
        $this->dropTable('paciente');
    }
}
