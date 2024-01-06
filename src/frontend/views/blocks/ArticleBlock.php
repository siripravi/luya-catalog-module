<?php

use luya\cms\widgets\NavTree;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use luya\helpers\ArrayHelper;
use siripravi\catalog\frontend\widgets\Carousel;
use luya\admin\filters\MediumCrop;
use luya\admin\filters\LargeCrop;
use app\modules\cart\models\Cart;


/**
 * View file for block: GroupBlock
 *
 * File has been created with `block/create` command on LUYA version 1.0.0.
 *
 * @param $this->varValue('elements');
 *
 * @var $this \luya\cms\base\PhpBlockView
 */

//\siripravi\catalog\frontend\assets\Main::register(Yii::$app->view);
$url = $this->extraValue('ajaxLink');
$articleInfo = $this->extraValue('articleInfo');
$article = $articleInfo['model'];
$thumbnails = $articleInfo['thumbnails'];
$images = $articleInfo['images'];
$product = $articleInfo['product'];
$features = $articleInfo['features'];
?>
<div class="container py-5">
    <div class="row">
        <h1 class="fw-bold"><?= $article->name; ?></h1>
        <div class="col-6">

            <?= $this->placeholderValue('pleftt'); ?>
            <?php if ($images) : ?>
                <?php echo Carousel::widget([
                    'items' =>
                    $images,
                    'thumbnails'  => $thumbnails,
                    'options' => [
                        'data-interval' => 3, 'data-bs-ride' => 'scroll', 'class' => 'carousel product_img_slide',
                    ],
                    //'options'  => ['class' => 'carousel product_img_slide','ride'=>true]

                ]);  ?>
            <?php endif; ?>
        </div>
        <div class="col-6">

            <?= $this->placeholderValue('pright'); ?>
            <?php 
            $model = \Yii::$app->forms->model;
            $selected = ArrayHelper::typeCast(\Yii::$app->session->get('__formData', $model->attributes));
                echo "<pre>";    
                print_r($selected)    ;   
                $cart = Cart::getCart();
                print_r($cart); ?>
            <!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Launch demo modal
            </button> -->
            <?php /*echo "<pre>";
            echo "<p>REQUEST</p>";
            print_r(\Yii::$app->request->queryParams);
            echo "</pre>";*/
            ?>
            <!--?php foreach ($this->extraValue('foobar') as $model) {
            echo $model->name;
            echo " ";
            // assuming the title is an attribute of the Article model defined in the query part of the injector.

        } ?-->

        </div>

    </div>