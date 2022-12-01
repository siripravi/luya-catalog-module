<?php

use yii\db\Migration;

class m221127_172040_create_table_catalog_attr_group_ref extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_attr_group_ref}}',
            [
                'attr_id' => $this->integer()->notNull(),
                'group_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%catalog_attr_group_ref}}', ['attr_id', 'group_id']);

        $this->createIndex('fk-catalog_attr_group_ref-group_id', '{{%catalog_attr_group_ref}}', ['group_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_attr_group_ref}}');
    }
}
