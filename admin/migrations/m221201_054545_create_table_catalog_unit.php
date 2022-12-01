<?php

use yii\db\Migration;

class m221201_054545_create_table_catalog_unit extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_unit}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'code' => $this->string(100)->notNull(),
                'position' => $this->integer()->notNull()->defaultValue('0'),
                'enabled' => $this->boolean()->notNull()->defaultValue('1'),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_unit}}');
    }
}
