<?php

namespace app\modules\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Attr Group Ref.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $attr_id
 * @property integer $group_id
 */
class AttrGroupRef extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_attr_group_ref';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-attrgroupref';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attr_id' => Yii::t('app', 'Attr ID'),
            'group_id' => Yii::t('app', 'Group ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attr_id', 'group_id'], 'required'],
            [['attr_id', 'group_id'], 'integer'],
            [['attr_id', 'group_id'], 'unique', 'targetAttribute' => ['attr_id', 'group_id']],
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
