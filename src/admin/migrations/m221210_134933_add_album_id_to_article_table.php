<?php

use yii\db\Migration;

/**
 * Class m221210_134933_add_album_id_to_article_table
 */
class m221210_134933_add_album_id_to_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      //  $this->addColumn('catalog_article','album_id','integer');

        $this->createIndex('fk-catalog_article_gallery_album-album_id', 'gallery_album', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221210_134933_add_album_id_to_article_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221210_134933_add_album_id_to_article_table cannot be reverted.\n";

        return false;
    }
    */
}
