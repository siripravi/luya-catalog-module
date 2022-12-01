<?php

use yii\db\Migration;

class m221127_172032_create_table_catalog_group extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%catalog_group}}',
            [
                'id' => $this->primaryKey(),
                'parent_id' => $this->integer(),
                'slug' => $this->string()->notNull(),
                'cover_image_id' => $this->integer(),
                'images_list'    => $this->text(),
                'teaser'         => $this->string(),
                'text'          => $this->text(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                'main' => $this->boolean()->notNull()->defaultValue('0'),
                'position' => $this->integer()->notNull()->defaultValue('0'),
                'enabled' => $this->boolean()->notNull()->defaultValue('1'),
            ],
            $tableOptions
        );

        $this->createIndex('fk-catalog_group-parent_id', '{{%catalog_group}}', ['parent_id']);
        $this->createIndex('fk-catalog_group-cover_image_id', '{{%catalog_group}}', ['cover_image_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%catalog_group}}');
    }
}
