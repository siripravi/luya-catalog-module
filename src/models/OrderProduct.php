<?php

namespace siripravi\catalog\models\models;

use siripravi\catalog\models\Article;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_product".
 *
 * @property int $order_id
 * @property int $Article_id
 * @property string $name
 * @property int $count
 * @property int $price
 *
 * @property Order $order
 * @property Article $Article
 */
class OrderProduct extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_order_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'count', 'price'], 'required'],
            [['order_id', 'article_id', 'count', 'price'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order #',
            'article_id' => 'Article ',
            'name' => Yii::t('cart', 'Name'),
            'count' => Yii::t('cart', 'Count'),
            'price' => Yii::t('cart', 'Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }
}
