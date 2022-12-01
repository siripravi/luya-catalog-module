<?php

use yii\db\Migration;

class m221201_054534_create_table_catalog_article_value_ref extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_article_value_ref}}',
            [
                'article_id' => $this->integer()->notNull(),
                'value_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%catalog_article_value_ref}}', ['article_id', 'value_id']);

        $this->createIndex('fk-catalog_article_value_ref-value_id', '{{%catalog_article_value_ref}}', ['value_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_article_value_ref}}');
    }
}
