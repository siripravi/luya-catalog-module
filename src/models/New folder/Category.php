<?php

namespace siripravi\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Category.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $slug
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property tinyint $main
 * @property integer $position
 * @property tinyint $enabled
 */
class Category extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public $i18n = ['slug'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_category';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-category';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'slug' => Yii::t('app', 'Slug'),
            'image_id' => Yii::t('app', 'Image ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'main' => Yii::t('app', 'Main'),
            'position' => Yii::t('app', 'Position'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'image_id', 'created_at', 'updated_at', 'main', 'position', 'enabled'], 'integer'],
            [['slug', 'created_at', 'updated_at'], 'required'],
            [['slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'parent_id' => 'number',
            'slug' => 'text',
            'image_id' => 'number',
            'created_at' => 'number',
            'updated_at' => 'number',
            'main' => 'number',
            'position' => 'number',
            'enabled' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['parent_id', 'slug', 'image_id', 'created_at', 'updated_at', 'main', 'position', 'enabled']],
            [['create', 'update'], ['parent_id', 'slug', 'image_id', 'created_at', 'updated_at', 'main', 'position', 'enabled']],
            ['delete', false],
        ];
    }
}
