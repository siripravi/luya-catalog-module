<?php

use yii\db\Migration;

class m221128_055158_create_table_catalog_article extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_article}}',
            [
                'id' => $this->primaryKey(),
                'product_id' => $this->integer()->notNull(),
                'code' => $this->string(),
                'price' => $this->decimal(9, 2),
                'price_old' => $this->decimal(9, 2),
                'currency_id' => $this->integer()->notNull(),
                'unit_id' => $this->integer()->notNull(),
                'available' => $this->integer()->notNull()->defaultValue('1'),
                'image_id' => $this->integer(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                'position' => $this->integer()->notNull()->defaultValue('0'),
                'enabled' => $this->boolean()->notNull()->defaultValue('1'),
            ],
            $tableOptions
        );

        $this->createIndex('fk-catalog_article-unit_id', '{{%catalog_unit}}', ['id']);
        $this->createIndex('fk-catalog_article-currency_id', '{{%catalog_currency}}', ['id']);
        $this->createIndex('fk-catalog_article-product_id', '{{%catalog_product}}', ['id']);
        //$this->createIndex('idx-catalog_article-image_id', '{{%catalog_article}}', ['image_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_article}}');
    }
}
