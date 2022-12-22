<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:30
 *
 * @var $model dench\products\models\Product
 * @var $link string
 * @var $rating array
 */

use app\widgets\PriceTable;
use app\helpers\ImageHelper;
use yii\helpers\Html;

$variant = @$model->articles[0];
$price = 1;
if (@$model->articles[0]->price) {
    $price = $model->articles[0]->price;
    $available = 0;
    foreach ($model->articles as $variant) {
        if ($variant->enabled) {
            if ($variant->available < 0) {
                $available = -1;
            }
            if ($variant->available > 0) {
                $available = 1;
                break;
            }
        }
    }
}

?>

<div class="img-wrapper">
    <a data-productid="<?= $model->id;?>" href='<?="/product/".$model->slug; ?>'>
        <?php echo Html::img(Yii::$app->storage->getImage($model->cover_image_id)->source,
              ["width"=> 292, "height" => 204]) ?>  
    </a>
    <span class="price"><?php echo $price;?><br><span class="per">/ea</span></span>
</div>           
<span class="info"><?= $model->groups[0]->name; ?></span>
<p class="name"><a href="#"><?= $model->name; ?></a></p>

    