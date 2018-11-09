<?php

use yii\db\Migration;

class m181108_021250_create_pessoa extends Migration
{

    public function up()
    {
        $this->createTable('pessoa', [
            'id' => $this->primaryKey(),
            'email' => $this->string(60)->notNull(),
            'rg' => $this->string(13)->notNull(),
            'cpf' => $this->string(11)->notNull(),
            'accesstoken' => $this->string(120),
            'authkey' => $this->string(120)->notNull(),
            'datacriacao' => $this->timestamp()->notNull(),
            'dataalteracao' => $this->timestamp()->notNull(),
            'fone' => $this->string(9),
            'datanascimento' => $this->date(),
            'nome' => $this->string(90)->notNull(),
            'senha' => $this->string(60)->notNull(),
            'codpais' => $this->integer(),
            'responsavel' => $this->integer(),
            'foto' => $this->text(),
            'cep' => $this->string(8),
            'endereco' => $this->string(120),
            'complemento' => $this->string(120),
            'bairro' => $this->string(60),
            'cidade' => $this->string(60),
            'uf' => $this->string(2)
        ]);

        $this->addForeignKey('fk_cod_pais', 'pessoa', 'codpais', 'pais', 'id');
        $this->addForeignKey('fk_responsavel', 'pessoa', 'responsavel', 'pessoa', 'id');
    }

    public function down()
    {
       $this->dropForeignKey('fk_cod_pais', 'pessoa');
       $this->dropForeignKey('fk_responsavel', 'pessoa');
       $this->dropTable('pessoa');
    }
}
