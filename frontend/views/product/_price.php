<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.04.17
 * Time: 22:59
 *
 * @var $model dench\products\models\Product
 * @var $this yii\web\View
 * @var $rating array
 */

use app\modules\catalog\frontend\widgets\PriceTable;

if (@$model->prices) {
    $available = 0;
    //foreach ($model->articles as $variant) {
        if ($model->enabled) {
            if ($model->available < 0) {
                $available = -1;
            }
            if ($model->available > 0) {
                $available = 1;
               // break;
            }
        }
    //}
}
?>

<div class="row">
<?php if (@$model->prices) { ?>
    <div class="col-sm-12">
        <?= $model->name ?>
        <div class="float-right text-nowrap my-3">
            <?php
          /*  $floor = floor($rating['value']);
            for ($i = 0; $i < $floor; $i++) {
                echo '<i class="fa fa-star text-warning"></i> ';
            }
            if ($floor < $rating['value']) {
                echo '<i class="fa fa-star-half text-warning"></i> ';
            }*/
            ?>
          <!--  <a href="#reviews" class="text-muted ml-2"><= Yii::t('app', '{0, plural, =0{нет отзывов} =1{1 отзыв} one{# отзыв} few{# отзыва} many{# отзывов} other{# отзывов}}', $rating['count']); ?></a>-->
        </div>

        <div class="stock my-3">
            <?php if ($available > 0): ?>
                <div class="text-success"><i class="fa fa-check"></i> <?= Yii::t('app', 'In stock') ?></div>
            <?php elseif ($available < 0): ?>
                <div class="text-warning"><i class="fa fa-clock-o"></i> <?= Yii::t('app', 'On order') ?></div>
            <?php else: ?>
                <div class="text-danger"><i class="fa fa-times"></i> <?= Yii::t('app', 'Not available') ?></div>
            <?php endif; ?>
        </div>

        <?= PriceTable::widget([
            'id' => 'price' . $model->id,
            'article' => $model,
            'available' => $available,
        ]) ?>

        <div class="row">
            <div class="col">
                <?php if ($available !== 0): ?>
                  <!--  <button class="btn btn-primary btn-block btn-buy" rel="price?= $model->id ?>"><= $available > 0 ? Yii::t('app', 'Buy') : Yii::t('app', 'To order') ?></button>  -->
                  <button data-bxs-target="#offcanvasCart" data-bxs-toggle="offcanvas" class="btn btn-success btn-buy" rel="price<?= $model->id ?>">
					<?= $available > 0 ? Yii::t('app', 'Add to Cart') : Yii::t('app', 'Buy This') ?></button>
                 <?php endif; ?>
            </div>
            <div class="col">
                <span class="btn btn-link" onclick="window.print();"><i class="fa fa-print"></i> <?= Yii::t('app', 'Print version') ?></span>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
<?php } else {?>
    <div class="col-sm-12">
<?php } ?>
    </div>
</div>