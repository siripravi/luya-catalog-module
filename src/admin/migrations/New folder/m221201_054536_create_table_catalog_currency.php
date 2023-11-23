<?php

use yii\db\Migration;

class m221201_054536_create_table_catalog_currency extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_currency}}',
            [
                'id' => $this->primaryKey(),
                'code' => $this->string(3)->notNull(),
                'rate' => $this->decimal(8, 4)->notNull(),
                'position' => $this->integer()->notNull()->defaultValue('0'),
                'name' => $this->string()->notNull(),
                'before' => $this->string(20)->notNull(),
                'after' => $this->string(20)->notNull(),
                'enabled' => $this->boolean()->notNull()->defaultValue('1'),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_currency}}');
    }
}
