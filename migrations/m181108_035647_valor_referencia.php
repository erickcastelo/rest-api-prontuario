<?php

use yii\db\Migration;

class m181108_035647_valor_referencia extends Migration
{
    public function up()
    {
        $this->createTable('valorreferencia', [
            'id' => $this->primaryKey(),
            'faixaetaria' => $this->string(30),
            'intervalo1' => $this->string(30),
            'referencial' => $this->string(20),
            'unidade' => $this->string(20),
            'numexamelaboratorial' => $this->string(5),
        ]);
        $this->addForeignKey('fk_numexamelaboratorial', 'valorreferencia', 'numexamelaboratorial', 'examelaboratorial', 'numero');
    }

    public function down()
    {
        $this->dropForeignKey('fk_numexamelaboratorial', 'valorreferencia');
        $this->dropTable('valorreferencia');
    }
}
