<?php

namespace siripravi\catalog\frontend\blocks;

use siripravi\catalog\models\Article;
use siripravi\catalog\models\Product;
use siripravi\catalog\models\Feature;
use luya\cms\base\PhpBlock;
use yii\helpers\Html;
use luya\admin\filters\MediumCrop;
use luya\admin\filters\LargeCrop;
use yii\web\NotFoundHttpException;
use siripravi\catalog\frontend\blockgroups\BlockCollectionGroup;

/**
 * Portfolio Block.
 *
 * File has been created with `block/create` command on LUYA version 1.0.0. 
 */
class ArticleBlock extends PhpBlock
{
    /**
     * @var string The module where this block belongs to in order to find the view files.
     */
    public $module = 'catalog';

    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;

    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return BlockCollectionGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'Article Detail';
    }

    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'list-task'; // see the list of icons on: https://design.google.com/icons/
    }

    /**
     * @inheritDoc
     */
    public function config()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function extraVars()
    {
        return [
            'ajaxLink' => $this->createAjaxLink('HelloWorld', ['time' => time()]),
            'articleId' => \Yii::$app->request->get('id'),
            'articleInfo' => $this->getArticleInfo()
        ];
    }

    /**
     * {@inheritDoc} 
     *
     * @param {{vars.elements}}
     */
    public function admin()
    {
        return '<h5 class="mb-3">Article Detail</h5>';
    }

    /**
     * {@inheritdoc}
     */
    /* public function getViewPath()
    {
        return  dirname(__DIR__).'/src/views/blocks';
    }  */

    public function callbackHelloWorld($time)
    {
        return 'hallo world ' . $time;
    }

    public function getArticleInfo()
    {
        $articleInfo = []; $thumbnails = []; $images = [];
        $id = \Yii::$app->request->get('id') ?  \Yii::$app->request->get('id'):6;  //$this->varValue('articleId');
        $model = Article::findOne(['id' => $id, 'enabled' => 1]);
       /* if (!$model) {
            throw new NotFoundHttpException();
        }*/

        foreach ($model->images as $id => $photo) {
            $thumbnails[$id] = ['thumb' => $photo->image->applyFilter(MediumCrop::identifier())->source];
            $images[] = [
                'content' => Html::img($photo->image->applyFilter(LargeCrop::identifier())->source,['class'=>'img-fluid rounded mx-auto d-block']),
                'options' => [
                    // 'title' => $photo->alt,
                    'class' => ''
                ],
            ];
        }
        $product = Product::viewPage($model->product_id);

       /* if (!$product->enabled) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
        $features = Feature::getObjectList(true, $product->group_ids);
        
        $articleInfo['product'] = $product;
        $articleInfo['features'] = $features;
        $articleInfo['model'] = $model;
        $articleInfo['thumbnails'] = $thumbnails;
        $articleInfo['images'] = $images;
        return $articleInfo;
    }
}
