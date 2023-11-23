<?php

use yii\db\Migration;

class m221201_054533_create_table_catalog_article_price extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_article_price}}',
            [
                'article_id' => $this->integer()->notNull(),
                'currency_id' => $this->integer()->notNull(),
                'qty' => $this->integer()->notNull(),
                'price' => $this->float()->notNull(),
                'unit_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%catalog_article_price}}', ['article_id', 'currency_id', 'unit_id', 'qty']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_article_price}}');
    }
}
