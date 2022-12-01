<?php

use yii\db\Migration;

class m221201_054541_create_table_catalog_product_group_ref extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_product_group_ref}}',
            [
                'product_id' => $this->integer()->notNull(),
                'group_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%catalog_product_group_ref}}', ['product_id', 'group_id']);

        $this->createIndex('fk-catalog_product_group_ref-group_id', '{{%catalog_product_group_ref}}', ['group_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_product_group_ref}}');
    }
}
