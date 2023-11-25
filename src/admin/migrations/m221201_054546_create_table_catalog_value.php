<?php

use yii\db\Migration;

class m221201_054546_create_table_catalog_value extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_value}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(),
                'feature_id' => $this->integer()->notNull(),
                'position' => $this->integer()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );

        $this->createIndex('fk-catalog_value-feature_id', '{{%catalog_value}}', ['feature_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_value}}');
    }
}
