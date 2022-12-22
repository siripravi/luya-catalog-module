<?php

use yii\db\Migration;

class m221201_054542_create_table_catalog_product_related extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_product_related}}',
            [
                'product_id' => $this->integer()->notNull(),
                'related_id' => $this->integer()->notNull(),
                'position' => $this->integer()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%catalog_product_related}}', ['product_id', 'related_id']);

        $this->createIndex('fk-catalog_product_related-related_id', '{{%catalog_product_related}}', ['related_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_product_related}}');
    }
}
