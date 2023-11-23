<?php

namespace siripravi\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Attr Value.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property integer $attr_id
 * @property string $name
 * @property integer $position
 */
class AttrValue extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_attr_value';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-attrvalue';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'attr_id' => Yii::t('app', 'Attr ID'),
            'name' => Yii::t('app', 'Name'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attr_id', 'name'], 'required'],
            [['attr_id', 'position'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            //'attr_id' => 'number',
            'attr_id' => ['selectModel', 'modelClass' => Attr::class, 'valueField' => 'id', 'labelField' => 'name'],
            'name' => 'text',
            'position' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['attr_id', 'name', 'position']],
            [['create', 'update'], ['attr_id', 'name', 'position']],
            ['delete', false],
        ];
    }
}
