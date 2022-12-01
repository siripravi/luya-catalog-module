<?php

namespace app\modules\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use app\modules\eshop\admin\plugins\ArticleAttributesPlugin;

/**
 * Article.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property text $name
 * @property integer $product_id
 * @property string $code
 * @property decimal $price
 * @property decimal $price_old
 * @property integer $currency_id
 * @property integer $unit_id
 * @property integer $available
 * @property integer $image_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $position
 * @property tinyint $enabled
 */
class Article extends NgRestModel
{
    public $i18n = ['name', 'code'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_article';
    }

    /**
     * @inheritdoc
     */
    public static function ngRestApiEndpoint()
    {
        return 'api-catalog-article';
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Title'),            
            'product_id' => Yii::t('app', 'Product ID'),
            'code' => Yii::t('app', 'Code'),
            'price' => Yii::t('app', 'Price'),
            'price_old' => Yii::t('app', 'Price Old'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'unit_id' => Yii::t('app', 'Unit ID'),
            'available' => Yii::t('app', 'Available'),
            'image_id' => Yii::t('app', 'Image ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            //'position' => Yii::t('app', 'Position'),
            'enabled' => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','product_id','unit_id'], 'required'],
            [['product_id', 'unit_id', 'available', 'image_id', 'created_at', 'updated_at', 'position', 'enabled'], 'integer'],
           // [['price', 'price_old'], 'number'],
            [['code'], 'string', 'max' => 255],
            //[['values'], 'safe']
        ];
    }

    public function extraFields()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name'   =>  'text',
            //'product_id' => 'number',
            'product_id' => ['selectModel', 'modelClass' => Product::class, 'valueField' => 'id', 'labelField' => 'name'],
            'code' => 'text',
            //'price' => 'decimal',
           // 'price_old' => 'decimal',
            //'currency_id' => 'number',
            'unit_id' => 'number',
           // 'available' => 'number',
            'image_id' => 'number',
            'created_at' => 'number',
            'updated_at' => 'number',
            'position' => 'number',
            'enabled' => 'number',
        ];
    }

    public function ngRestExtraAttributeTypes()
    {
        return [
          //  'values' => [
          //      'class' => ArticleAttributesPlugin::class,
          //  ]
        ];
    }

    public function ngRestRelations()
    {
        return [
           ['label' => 'Prices', 'targetModel' => ArticlePrice::class,'apiEndpoint' => ArticlePrice::ngRestApiEndpoint(), 'dataProvider' => $this->getPrices()],
        ];
    }
    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['name','product_id', 'code', 'unit_id', 'image_id', 'created_at', 'updated_at', 'enabled']],
            [['create', 'update'], ['name','product_id', 'code', 'unit_id', 'image_id', 'enabled']],
            ['delete', false],
        ];
    }

    public function getPrices()
    {
        return $this->hasMany(ArticlePrice::class, ['article_id' => 'id']);
    }
    
   /* public function getAttributeValues()
    {
        return $this->hasMany(ArticleAttributeValue::class, ['article_id' => 'id']);
    }*/
    
    public function getValues()
    {
        $data = [];
        foreach ($this->attributeValues as $value) {
            $data[$value->set_id][$value->attribute_id] = $value->value;
        }
        
        return $data;
    }
    
    public function setValues($data)
    {
        if ($this->isNewRecord) {
            $this->on(self::EVENT_AFTER_INSERT, function () use ($data) {
                $this->updateSetValues($data);
            });
        } else {
            $this->updateSetValues($data);
        }
    }
    
    private function updateSetValues($data)
    {
        $this->unlinkAll('attributeValues', true);
        foreach ($data as $setId => $values) {
            foreach ($values as $attributeId => $attributeValue) {
                $model = new ArticleAttributeValue();
                $model->attribute_id = $attributeId;
                $model->value = $attributeValue;
                $model->set_id = $setId;
                $this->link('attributeValues', $model);
            }
        }
    }

    public function getSets()
    {
        return $this->hasMany(Set::class, ['id' => 'set_id'])->viaTable(ProductSetRef::tableName(), ['product_id' => 'id']);
    }

    //return self::find()->joinWith(['Group'])->andFilterWhere(['nxt_feature.enabled' => $enabled])->andFilterWhere(['category_id' => $category_ids])->orderBy('position')->all();
}
