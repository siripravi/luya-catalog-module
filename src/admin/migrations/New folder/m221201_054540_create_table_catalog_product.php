<?php

use yii\db\Migration;

class m221201_054540_create_table_catalog_product extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_product}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(225)->notNull(),
                'slug' => $this->string()->notNull(),
                'brand_id' => $this->integer(),
                'cover_image_id' => $this->integer(),
                'images_list' => $this->text(),
                'teaser' => $this->string(),
                'text' => $this->text(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                'price_from' => $this->integer()->notNull()->defaultValue('0'),
                'view' => $this->string(),
                'position' => $this->integer()->notNull()->defaultValue('0'),
                'enabled' => $this->boolean()->notNull()->defaultValue('1'),
            ],
            $tableOptions
        );

        $this->createIndex('fk-catalog_product-brand_id', '{{%catalog_product}}', ['brand_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_product}}');
    }
}
