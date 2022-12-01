<?php

use yii\db\Migration;

class m221201_054543_create_table_catalog_product_status extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_product_status}}',
            [
                'product_id' => $this->integer()->notNull(),
                'status_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%catalog_product_status}}', ['product_id', 'status_id']);

        $this->createIndex('fk-product_status-status_id', '{{%catalog_product_status}}', ['status_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_product_status}}');
    }
}
