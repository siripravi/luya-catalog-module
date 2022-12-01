<?php

use yii\db\Migration;

class m221128_055236_create_table_catalog_article_attr_ref extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_article_attr_ref}}',
            [
                'article_id' => $this->integer()->notNull(),
                'attr_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%catalog_article_attr_ref}}', ['article_id', 'attr_id']);

        $this->createIndex('fk-catalog_article_attr-attr_id', '{{%catalog_article_attr_ref}}', ['attr_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_article_attr_ref}}');
    }
}
