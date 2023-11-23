<?php

namespace siripravi\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use yii\helpers\ArrayHelper;

/**
 * Value.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property string $name
 * @property integer $feature_id
 * @property integer $position
 */
class Value extends NgRestModel
{
    public $values_json = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_value}}';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-value';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'feature_id' => Yii::t('app', 'Feature ID'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feature_id'], 'required'],
            [['feature_id', 'position'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name' => 'text',
            'feature_id' => ['selectModel', 'modelClass' => Feature::class, 'valueField' => 'id', 'labelField' => 'name'],
            'position' => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['name', 'feature_id', 'position']],
            [['create', 'update'], ['name', 'feature_id', 'position']],
            ['delete', false],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeature()
    {
        return $this->hasOne(Feature::class, ['id' => 'feature_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariants()
    {
        return $this->hasMany(Variant::class, ['id' => 'variant_id'])->viaTable('catalog_article_value', ['value_id' => 'id']);
    }

    /**
     * @param integer|null $feature_id
     * @return array
     */
    public static function getList($feature_id)
    {
        $values = self::find()->andFilterWhere(['feature_id' => $feature_id])->orderBy('position')->all();

        return ArrayHelper::map($values, 'id', 'name');
    }



    public static function getListEx($feature_id, $group_id)
    {
        $query = self::find();
        $query->joinWith(['feature']);
        $query->joinWith(['articles.product.groups']);
        $query->andWhere(['feature_id' => $feature_id]);
        $query->andWhere(['group_id' => $group_id]);
        $query->andWhere(['catalog_article.enabled' => true]);
        $query->andWhere(['catalog_product.enabled' => true]);
        $ids = $query->select('catalog_value.id')->groupBy(['catalog_value.id'])->column();

        return ArrayHelper::map(self::find()->andFilterWhere(['feature_id' => $feature_id])->where(['id' => $ids])->orderBy('position')->all(), 'id', 'name');
    }
}
