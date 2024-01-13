<?php

namespace siripravi\catalog\frontend\blocks;

use luya\forms\FieldBlockTrait;
use siripravi\catalog\models\Article;
use siripravi\catalog\models\Product;
use siripravi\catalog\models\Feature;

use app\blocks\FormBlock;
use luya\admin\filters\MediumCrop;
use luya\admin\filters\LargeCrop;
use luya\helpers\ArrayHelper;
use yii\helpers\Html;

class ImageSliderBlock extends FormBlock
{
    use FieldBlockTrait;

    public $module = 'catalog';

    public function name()
    {
        return 'Image Slider';
    }

    public function admin()
    {
        return '<p> Image Carousel
        <span class="block__empty-text">Image View</span>       
        <header>
            <h3>
           <span class="block__empty-text">shwo images</span>            
            </h3>
        </header>              
        </p>';
    }

    public function extraVars()
    {
        return [
            'articleImages' => $this->getArticleImages(),
            'ajaxLink' => $this->createAjaxLink('HelloWorld', ['time' => time()]),
        ];
    }
    /* public function getArticle()
    {
        $session = \Yii::$app->session;
        $id = \Yii::$app->request->get('id') ?  \Yii::$app->request->get('id') : $session['__params']['id'];
        return Article::findOne(['id' => $id, 'enabled' => 1]);
    }*/
    public function callbackHelloWorld($time)
    {
        return 'hallo world ' . $time;
    }
    public function getArticleImages()
    {
        $params = \Yii::$app->request->queryParams;
        $id = \Yii::$app->request->get('id');
        // $session = \Yii::$app->session;
        $articleImages = [];
        $thumbnails = [];
        $images = [];
        //?  \Yii::$app->request->get('id') : $session['__params']['id'];  //$this->varValue('articleId');

        if (!empty($id)) {
            $model = Article::findOne(['id' => $id, 'enabled' => 1]);
            if ($model) {
                foreach ($model->images as $id => $photo) {
                    $thumbnails[$id] = ['thumb' => $photo->image->applyFilter(MediumCrop::identifier())->source];
                    $images[] = [
                        'content' => Html::img($photo->image->applyFilter(LargeCrop::identifier())->source, ['class' => 'img-fluid rounded mx-auto d-block']),
                        'options' => [
                            // 'title' => $photo->alt,
                            'class' => ''
                        ],
                    ];
                }
            }
        } 
        $articleImages['thumbnails'] = $thumbnails;
        $articleImages['images'] = $images;
        return $articleImages;
    }
}
