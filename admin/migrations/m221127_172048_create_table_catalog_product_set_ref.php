<?php

use yii\db\Migration;

class m221127_172048_create_table_catalog_product_set_ref extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_product_set_ref}}',
            [
                'product_id' => $this->integer()->notNull(),
                'set_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%catalog_product_set_ref}}', ['product_id', 'set_id']);

        $this->createIndex('fk-catalog_product_set_ref-set_id', '{{%catalog_product_set_ref}}', ['set_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_product_set_ref}}');
    }
}
