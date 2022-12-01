<?php

namespace app\modules\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * Group.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $slug
 * @property integer $cover_image_id
 * @property text $images_list
 * @property string $teaser
 * @property text $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property tinyint $main
 * @property integer $position
 * @property tinyint $enabled
 */
class Group extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_group';
    }

    public function behaviors()
    {
    return [
        [
            'class' => TimestampBehavior::class,
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'value' => new Expression('NOW()'),
        ],
    ];
    }
    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-group';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name'      => Yii::t('app', 'Title'),
            'slug' => Yii::t('app', 'Slug'),
            'cover_image_id' => Yii::t('app', 'Cover Image ID'),
            'images_list' => Yii::t('app', 'Images List'),
            'teaser' => Yii::t('app', 'Teaser'),
            'text' => Yii::t('app', 'Text'),
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
            [['parent_id', 'cover_image_id', 'created_at', 'updated_at','main', 'position', 'enabled'], 'integer'],
            [['slug'], 'required'],
            [['images_list', 'text', 'name'], 'string'],
            [['slug', 'teaser'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'parent_id' => 'number',
            'name'      => 'text',
            'slug' => 'text',
            'cover_image_id' => 'image',
            'images_list' => 'imageArray',
            'teaser' => 'text',
            'text' => 'textarea',
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
            ['list', ['name','parent_id', 'slug', 'cover_image_id', 'images_list', 'teaser', 'text', 'created_at', 'updated_at', 'main', 'position', 'enabled']],
            [['create', 'update'], ['name','parent_id', 'slug', 'cover_image_id', 'images_list', 'teaser', 'text', 'main', 'position', 'enabled']],
            ['delete', false],
        ];
    }
}
