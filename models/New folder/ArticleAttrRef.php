<?php

namespace app\modules\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Article Attr Ref.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $article_id
 * @property integer $attr_id
 */
class ArticleAttrRef extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_article_attr_ref';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-articleattrref';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => Yii::t('app', 'Article ID'),
            'attr_id' => Yii::t('app', 'Attr ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'attr_id'], 'required'],
            [['article_id', 'attr_id'], 'integer'],
            [['article_id', 'attr_id'], 'unique', 'targetAttribute' => ['article_id', 'attr_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['']],
            [['create', 'update'], ['']],
            ['delete', false],
        ];
    }
}
