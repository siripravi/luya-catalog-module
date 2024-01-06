<?php
namespace siripravi\catalog;
use app\modules\cart\models\Cart;
use yii\helpers\ArrayHelper;
class AfterSaveHandler
{
    /**
     * Handles the after login event process to send emails
     *
     * @param FormEvent $event Event object form
     *
     * @return null
     */
    public static function handleAfterSave(\siripravi\catalog\AfterSaveEvent $event)
    {
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