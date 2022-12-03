<?php

namespace app\modules\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Article Value Ref.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $article_id
 * @property integer $value_id
 */
class ArticleValueRef extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_article_value_ref';
    }

   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => Yii::t('app', 'Article ID'),
            'value_id' => Yii::t('app', 'Value ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'value_id'], 'required'],
            [['article_id', 'value_id'], 'integer'],
            [['article_id', 'value_id'], 'unique', 'targetAttribute' => ['article_id', 'value_id']],
        ];
    }
   
}
