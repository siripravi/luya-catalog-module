<?php

/**
 * Created by PhpStorm.
 * User: siripravi
 * Date: 20.11.23
 * Time: 14:02
 */

namespace siripravi\catalog\frontend\widgets;

use siripravi\catalog\models\Cart;
use siripravi\catalog\models\Article;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class CartWidget extends Widget
{
    public $id = 'bag';

    public $options = [];

    public $urlCart = ['/catalog/default/index'];

    public function run()
    {
        $cart = Cart::getCart();
        $variant_ids = array_keys($cart);
        $items = Article::find()->where(['id' => $variant_ids])->andWhere(['enabled' => true])->all();
        
        return $this->render("ocart",['cartUrl' => $this->urlCart,'items'=> $items, 'cart' => $cart]);
    }

    private function registerClientScript()
    {
        $url = Url::to(['/catalog/default/block']);

        $js = <<< JS
function reloadCart() {
    $.get('{$url}', function(data) {
        $('#{$this->id}').after(data).remove();
    });
}
JS;
  //  $this->view->registerJs($js);
    }
}
