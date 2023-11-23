<?php

/** @var $this yii\web\View */
/** @var $page app\modules\main\components\Page */
/** @var $categories dench\products\models\Category[] */
/** @var $dataProvider yii\data\ActiveDataProvider */


use siripravi\catalog\models\Group;
use yii\helpers\Url;
use yii\widgets\ListView;

//$this->params['breadcrumbs'][] = $page->name;
?>
<h1 class="mb-3"><!--?= $page->title ?--></h1>

<!--?php if ($page->short) : ?>
    <div class="card mb-3">
        <div class="card-body">
            <= $page->short ?>
      </div>
    </div>  
<php endif; ?-->
<section class="products-categories pt-6" style="margin-top:83px;">
    <div class="container">
        <h2 class="mb-3 text-center">Our Menu</h2>
        <div class="row">
            <?php foreach ($categories as $category) : ?>
                <?php
                $url = Url::to((count($category->categories)) ? ['category/pod', 'slug' => $category->slug] : ['category/view', 'slug' => $category->slug]);
                ?>
                <div class="col-md-4"> <!-- new code -->
                    <div class="card mb-4 product-wap rounded-0">
                        <div class="card rounded-0">
                            <?php if ($category->cover_image_id) { ?>
                                <img src="<?= Yii::$app->storage->getImage($category->cover_image_id)->source ?>" alt="<?= $category->name ?>" title="<?= $category->name ?>" class="card-img rounded-0 img-fluid">
                            <?php } else { ?>
                                <img class="img-fluid" src="<?= Yii::$app->params['image']['size']['category']['none'] ?>" alt="">
                            <?php } ?>

                        </div>
                        <div class="card-body">
                            <a href="<?= $url ?>" class="link">
                                <span class="cat"><i class="uil uil-tag-alt"></i> <?= $category->name ?></span>
                            </a>
                            <!--  <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <li>M/L/X/XL</li>
                                    <li class="pt-2">
                                        <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                    </li>
                                </ul>  -->
                            <!-- <ul class="list-unstyled d-flex justify-content-center mb-1">
                                    <li>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-warning fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                        <i class="text-muted fa fa-star"></i>
                                    </li>
                                </ul>  -->
                            <!--<p class="text-center mb-0">$250.00</p>  -->
                        </div>
                    </div>
                </div> <!-- end new code -->

            <?php endforeach; ?>

        </div>
    </div>
</section>

<!--?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'layout' => "{items}\n{pager}",
    'emptyTextOptions' => [
        'class' => 'alert alert-danger',
    ],
    'options' => [
        'class' => 'list-group mb-4',
    ],
    'itemOptions' => [
        'class' => 'list-group-item',
    ],
]);
?-->

<!--
<php if (!Yii::$app->request->get('page') && $page->text) : ?>
    <div class="card mb-3">
        <div class="page-seo card-body">
            <h2><= $page->title ?></h2>
			 <= $page->text ?>
        </div>
    </div>
<php endif; ?>
-->