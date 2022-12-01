<?php

namespace app\modules\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

/**
 * Product Set Ref.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $product_id
 * @property integer $set_id
 */
class ProductSetRef extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_product_set_ref}}';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-productsetref';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'set_id' => Yii::t('app', 'Set ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'set_id'], 'required'],
            [['product_id', 'set_id'], 'integer'],
            [['product_id', 'set_id'], 'unique', 'targetAttribute' => ['product_id', 'set_id']],
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
