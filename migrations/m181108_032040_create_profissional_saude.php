<?php

use yii\db\Migration;

class m181108_032040_create_profissional_saude extends Migration
{
    public function up()
    {
        $this->execute('
            create table profissionalsaude(
                id serial not null,
                numero varchar(40) not null,
                emailprofissional varchar(60),
                registro varchar(90),
                codprofissao int,
                primary key(id),
                foreign key (codprofissao) references profissao(id)
            )inherits (pessoa)
        ');

        $this->addForeignKey('fk_cod_pais', 'profissionalsaude', 'codpais', 'pais', 'id');
        $this->addForeignKey('fk_responsavel', 'profissionalsaude', 'responsavel', 'profissionalsaude', 'id');
        $this->addForeignKey('fk_cod_profissao', 'profissionalsaude', 'codprofissao', 'profissao', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_cod_pais', 'profissionalsaude');
        $this->dropForeignKey('fk_responsavel', 'profissionalsaude');
        $this->dropForeignKey('fk_cod_profissao', 'profissionalsaude');
        $this->dropTable('profissionalsaude');
    }
}
