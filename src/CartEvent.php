<?php

namespace siripravi\catalog;

use yii\base\Event;
use app\modules\cart\models\Cart;
use yii\helpers\ArrayHelper;
/**
 * A form after save event to attach in the config.
 * 
 * ```php
 * 'forms' => [
 *     'class' => 'luya\forms\Forms',
 *     'on afterSave' => function(\luya\forms\AfterSaveEvent $event) {
 *         // do something with event model 
 *     }
 * ]
 * ```
 * 
 * @since 1.6.0
 */
class CartEvent extends Event
{
    public $model;

    public function onDance($event){
        $model = $event->model;
        $id = implode("+", $model->Features);
        $ftext = $model->FeatureText;
        $pid = $model->Pid;
        $price = $model->Price;
        $cart = Cart::getCart();
       
        if (isset($cart[$id])){
            return false;
        }
        $qty = isset($cart[$id]) ? $cart[$id]["qty"] + 1 : 1;
        ArrayHelper::setValue($cart, $id, ["qty" =>  $qty, "pid" => $pid, "ftext" => $ftext, "price" => $price]);
        Cart::setCart($cart);
        return true;
    }
}