<?php

use luya\cms\widgets\NavTree;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use siripravi\catalog\frontend\widgets\Carousel;

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

<h1><?= $article->name; ?></h1>
<!--php
echo NavTree::widget([
    'findQuery' => Yii::$app->menu->find()->where(['container' => 'default', 'parent_nav_id' => 0])->all(),
    // or
    'startItem' => Yii::$app->menu->home, // if defined, startItem will be used, otherwise findQuery
    'maxDepth' => 2,
    'linkActiveClass' => 'link-active',
    'itemActiveClass' => 'item-active',
    'listDepthClassPrefix' => 'list-depth-',
    'wrapperOptions' => [
        'tag' => 'nav',
        'class' => 'navigation'
    ],
    'itemOptions' => [
        'tag' => 'li',
        'class' => 'item depth-{{depth}} alias-{{alias}}'
    ],
    'linkOptions' => [
        'tag' => 'a',
        'class' => 'link depth-{{depth}} alias-{{alias}}'
    ],
]);
?-->

<!--<div class="col-lg-6 mt-5">
    <p class="time"><= $this->extraValue('articleId'); ?></p>
    <php echo Carousel::widget([
        'items' =>     $images,
        'thumbnails'  => $thumbnails,
        'options' => [
            'data-interval' => 3, 'data-bs-ride' => 'scroll', 'class' => 'carousel product_img_slide',
        ],
        //'options'  => ['class' => 'carousel product_img_slide','ride'=>true]

    ]);  >
</div> -->

<?= $article->text; ?>

<!--= $this->render('_price', [
                'article' => $article,
                'features' => $features,
                // 'rating' => $rating,
                
            ]) ?-->
<div class="form xhidden-xs px-4">
    <?php
    //   print_r(ArticlePrice::getPriceList(6,8));
    //  print_r( $priceList = $article->getPricesDef());
    //   print_r(ArrayHelper::map($priceList,'feature_id','name','feature_id'));

    /*  $floor = floor($rating['value']);
            for ($i = 0; $i < $floor; $i++) {
                echo '<i class="fa fa-star text-warning"></i> ';
            }
            if ($floor < $rating['value']) {
                echo '<i class="fa fa-star-half text-warning"></i> ';
            }*/
    ?>
    <!--  <a href="#reviews" class="text-muted ml-2"><= Yii::t('app', '{0, plural, =0{нет отзывов} =1{1 отзыв} one{# отзыв} few{# отзыва} many{# отзывов} other{# отзывов}}', $rating['count']); ?></a>-->

    <?php Pjax::begin(['id' => 'feature-pjax']); ?>
    <div class="col-6" style="color:#323232;display: inline-block;padding-left:10px">
        <div style="padding-right: 0;">
            <span style="vertical-align:super;font-size:31px; padding-right:5px;" class="moneySymbol">₹</span>
            <span class="product-price moneyCal" data-inr="<?= $article->price; ?>" style="color: #222; font-size: 48px; font-weight: 600;" id="productPrice"><?= $article->price; ?></span>
        </div>
    </div>
    <?php if (empty($features)) : ?>
        <?= Html::tag('div', Yii::t('app', 'Select a category!'), ['class' => 'alert alert-danger']) ?>
    <?php else :

    ?>
        <?php foreach ($features as $id => $feature) {
            $priceList = $article->getPricesDef($feature->id);
            //  echo "<pre>";
            //  print_r($priceList); die;
            echo "<h5>" . $feature->name . "</h5>";
            echo "<div class='card card-outline featSel p-4'>";
            echo "<div class='d-flex flex-wrap align-content-start'>";
            echo Html::radioList(
                'buy[' . $article->product_id . '][' . $feature->id . ']',
                "",
                ArrayHelper::map($priceList, "price", "ftext"),
                [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        // $inpId = str_replace(["buy[","]"],"_",str_replace([']['], '_', $name));
                        $checked = ($index == 0 && $value > 0) ? 'checked' : '';
                        $return = '<div class="p-2 flex-fill fsel ' . $checked . '">';
                        $return .= '<input type="radio" id="' . $name . $index . '" class="btn-check" data-ftext="' . $label . '" name="' . $name . '" value="' . $value . '" title="click" autocomplete="off" ' . $checked . '>';
                        $return .= '<label class="btn btn-outline-warning" for="' . $name . $index . '">' . '<i class="bi bi-circle pe-2" style="font-size:34px;"></i><span class="text-dark">' . ucwords($label) . '</span></label>';
                        $return .= "</div>";
                        return $return;
                    },
                    'class' => 'd-flex text-inline'
                ]
            );
            echo "</div>";
            echo "</div>";
        }
        ?>
    <?php endif; ?>
    <?php Pjax::end(); ?>
    <div class="row">
        <?php if ($article->available !== 0) : ?>
            <form id="cart-form" action="<?= Url::to('/cart/bag/index'); ?>">
                <button type="submit" data-key="" data-ftext="" data-product="<?= $article->id; ?>" data-price="<?= $article->price; ?>" data-bs-target="#offcanvasCart" data-bs-toggle="offcanvas" class="btn btn-success btn-buy" rel="price<?= $article->id ?>">
                    <?= $article->available > 0 ? Yii::t('app', 'Order This') : Yii::t('app', 'Buy This Now') ?></button>
            </form>
        <?php endif; ?>
    </div>
</div>


<!--
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="section-title position-relative text-center mx-auto mb-5 pb-3" style="max-width: 600px;">
            <h2 class="text-primary font-secondary">Our Menu</h2>
            <h1 class="display-4 text-uppercase">We Sell These</h1>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <php foreach ($this->extraValue('elements')['categories'] as $key => $element) : ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <a data-category="<= $element->slug; ?>" href="/menu/<= $element->slug; ?>">
                            <img class="card-img-top" src="<= Yii::$app->storage->getImage($element->cover_image_id)->source ?>" alt="" height="230">

                        </a>
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="name"><= $element->name; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            <php endforeach; ?>
        </div>
    </div>
</section>
-->
<?php
$js = <<<JS
            $.ajax({                
                method: "GET",
                url: "{$url}",
                dataType: "html"
                }).done(function(data) {
                    console.log(data);
               $('.time').append(data);            
            });       
        JS;
$this->registerJs($js);
?>