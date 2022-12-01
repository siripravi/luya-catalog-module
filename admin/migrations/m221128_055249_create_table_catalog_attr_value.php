<?php

use yii\db\Migration;

class m221128_055249_create_table_catalog_attr_value extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_attr_value}}',
            [
                'id' => $this->primaryKey(),
                'attr_id' => $this->integer()->notNull(),
                'name'  => $this->string()->notNull(),
                'position' => $this->integer()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );

        $this->createIndex('fk-catalog_attr_value-attr_id', '{{%catalog_attr_value}}', ['attr_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_attr_value}}');
    }
}
