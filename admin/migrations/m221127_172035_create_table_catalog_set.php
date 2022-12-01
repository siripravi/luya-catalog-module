<?php

use yii\db\Migration;

class m221127_172035_create_table_catalog_set extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_set}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'position' => $this->integer()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_set}}');
    }
}
