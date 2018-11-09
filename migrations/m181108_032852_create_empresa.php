<?php

use yii\db\Migration;

class m181108_032852_create_empresa extends Migration
{
    public function up()
    {
        $this->execute('
            create table empresa(
                id serial not null,
                numero varchar(40) not null,
                cnpj varchar(15),
                fantasia varchar(90),
                servicoLaboratorial varchar(30),
                servicoImagem varchar(30),
                primary key(id)
            )inherits (pessoa)
        ');

        $this->addForeignKey('fk_cod_pais', 'empresa', 'codpais', 'pais', 'id');
        $this->addForeignKey('fk_responsavel', 'empresa', 'responsavel', 'empresa', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_cod_pais', 'empresa');
        $this->dropForeignKey('fk_responsavel', 'empresa');
        $this->dropTable('empresa');
    }
}
