<?php

namespace app\modules\catalog\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;
use luya\admin\ngrest\plugins\CheckboxRelationActiveQuery;
use luya\admin\ngrest\plugins\SelectRelationActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Product.
 * 
 * File has been created with `crud/create` command. 
 *
 * @property integer $id
 * @property text $name
 * @property string $slug
 * @property integer $brand_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $price_from
 * @property string $view
 * @property integer $position
 * @property tinyint $enabled
 */
class Product extends NgRestModel
{
    /**
     * @inheritdoc
     */
    public $i18n = ['name','slug', 'view'];

    /**
     * @var array
     */
    public $adminGroups = [];
    
    /**
     * @var array
     */
    public $adminSets = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_product';
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
        return 'api-catalog-product';
    }

    public function ngRestRelations()
    {
        //$query = Article::find()->where(['product_id'=>1]);
       // echo "<pre>"; print_r( $query); die;//->createCommand()->getRawSql(); die;
        return [
            ['label' => 'Articles', 'targetModel' => Article::class,'apiEndpoint' => Article::ngRestApiEndpoint(), 'dataProvider' => $this->getArticles()],
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
            'slug' => Yii::t('app', 'Slug'),
            'brand_id' => Yii::t('app', 'Brand ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'price_from' => Yii::t('app', 'Price From'),
            'view' => Yii::t('app', 'View'),
            'position' => Yii::t('app', 'Position'),
            'enabled' => Yii::t('app', 'Enabled'),
            'adminGroups' => 'Categories',
            //'adminSets' => 'Features',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['brand_id', 'created_at', 'updated_at', 'price_from', 'position', 'enabled'], 'integer'],
            [['name','slug', 'view'], 'string', 'max' => 255],
            [['adminGroups'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestAttributeTypes()
    {
        return [
            'name'          => 'text',
            'slug'          => 'text',
            //'brand_id'    => 'number',
            'brand_id'  =>  ['class' => SelectRelationActiveQuery::class, 'query' => $this->getBrands(), 'labelField' => ['name'], 'asyncList' => true],
            //'brand_id'      => ['selectModel', 'modelClass' => Brand::class],
            'created_at'    => 'number',
            'updated_at'    => 'number',
            'price_from'    => 'number',
            'view'          => 'text',
            'position'      => 'number',
            'enabled'       => 'number',
        ];
    }

    /**
     * @inheritdoc
     */
    public function ngRestScopes()
    {
        return [
            ['list', ['name','slug', 'brand_id', 'created_at', 'updated_at', 'price_from', 'view', 'position', 'enabled']],
            [['create', 'update'], ['name','slug', 'adminGroups', 'brand_id', 'price_from', 'view', 'position', 'enabled']],
            ['delete', false],
        ];
    }

    public function ngRestExtraAttributeTypes()
    {
        return [
            'adminGroups' => [
                'class' => CheckboxRelationActiveQuery::class,
                'query' => $this->getGroups(),
                'labelField' => ['name'],
            ],
          /*  'adminSets' => [
                'class' => CheckboxRelationActiveQuery::class,
                'query' => $this->getSets(),
                'labelField' => ['name'],
            ]*/
        ];
    }

    public function extraFields()
    {
        return ['adminGroups'];  //adminSets
    }

    public function getArticles()
    {
        return $this->hasMany(Article::class, ['product_id' => 'id']);
    }
    

    public function getGroups()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])->viaTable(ProductGroupRef::tableName(), ['product_id' => 'id']);
    }

    /**
     * @return Article
     */
    public function getBrands()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }
    
   /* public function getSets()
    {
        return $this->hasMany(Set::class, ['id' => 'set_id'])->viaTable(ProductSetRef::tableName(), ['product_id' => 'id']);
    }*/
}
