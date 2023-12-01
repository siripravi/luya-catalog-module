<?php

namespace siripravi\catalog\frontend\controllers;

use siripravi\catalog\actions\DeliveryAction;
use siripravi\catalog\actions\PaymentAction;
use siripravi\catalog\models\Cart;
use siripravi\catalog\models\Order;
use siripravi\catalog\models\OrderForm;
use siripravi\catalog\widgets\CartWidget;
//use app\helpers\ImageHelper;
//use app\modules\page\models\Page;
use siripravi\catalog\models\Article;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class CartController
 * @package app\controllers
 */
class BagController extends Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\AjaxFilter',
                'only' => ['modal', 'add', 'del'],
            ],
        ];
    }

    public function actions()
    {
        return [
            'delivery' => DeliveryAction::class,
            'payment' => PaymentAction::class,
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
       // $page = Page::viewPage('shopping-cart',true);

        $cart = Cart::getCart();

        $variant_ids = array_keys($cart);

        /** @var Variant[] $items */
        $items = Variant::find()->where(['id' => $variant_ids])->andWhere(['enabled' => true])->all();

        $notAvailable = false;

        foreach ($items as $item) {
            if ($item->available <= 0) {
                $notAvailable = true;
            }
        }

        $model = new OrderForm();

        $model->scenario = 'user';

        if ($model->load(Yii::$app->request->post()) && $order_id = $model->send()) {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'order',
                'value' => $order_id,
                'expire' => time() + 3600 * 24 * 7,
            ]));
            Yii::$app->session->setFlash('orderSubmitted');
               //if Yii::$app->params['sendSputnikOrder'] &&
            if ( $model->email && $order = Order::findOne($order_id)) {
                $products = [];
                foreach ($order->products as $product) {
                    $image = null;
                    if ($product->image) {
                        $image = Url::to(ImageHelper::thumb($product->image->id, 'micro'), 'https');
                    } elseif ($product->product->image) {
                        $image = Url::to(ImageHelper::thumb($product->product->image->id, 'micro'), 'https');
                    }
                    $products[] = [
                        'imageUrl' => $image,
                        'url' => Url::to(['/product/index', 'slug' => $product->product->slug], 'https'),
                        'name' => (string)$order->cartItemName[$product->id],
                        'cost' => (string)$order->cartItemPrice[$product->id],
                        'quantity' => (string)$order->cartItemCount[$product->id],
                    ];
                }
                /*Yii::$app->esputnik->event('zakaz', $order->email, [
                    'externalOrderId' => (string)$order->id,
                    'firstName' => (string)$order->buyer->name,
                    'email' => (string)$order->email,
                    'phone' => (string)$order->phone,
                    'totalCost' => (string)$order->amount,
                    'paymentMethod' => $order->payment_id ? (string)$order->paymentMethod->name : null,
                    'deliveryMethod' => $order->delivery_id ? $order->deliveryMethod->name . ($order->delivery ? ', ' . Html::encode($order->delivery) : null) : null,
                    'products' => $products,
                ]);*/
            }

            return $this->redirect(['/order', 'id' => $order_id, 'hash' => md5($order_id . Yii::$app->params['order_secret'])]);
        }

        return $this->render('index', [
          //  'page' => $page,
            'items' => $items,
            'cart' => $cart,
            'model' => $model,
            'notAvailable' => $notAvailable,
        ]);
    }

    /**
     * @return string
     */
    public function actionModal()
    {
        $footer = Html::button(Yii::t('app', 'Continue shopping'), ['class' => 'btn btn-primary mr-auto', 'data-dismiss' => 'modal']);
        $footer .= Html::a(Yii::t('app', 'Place an order'), ['/bag/index'], ['class' => 'btn btn-warning']);

        $cart = Cart::getCart();

        $variant_ids = array_keys($cart);

        $items = Variant::find()->where(['id' => $variant_ids])->andWhere(['enabled' => true])->all();

        $data = [
            'title' => Yii::t('app', 'Buy'),
            'body' => $this->renderAjax('modal', [
                'items' => $items,
                'cart' => $cart,
            ]),
            'footer' => $footer,
            'dialog' => 'modal-lg',
        ];

        return Json::encode($data);
    }


    /**
     * @return string
     */
    public function actionOffcanvas()
    {
        $footer = Html::button(Yii::t('app', 'Continue shopping'), ['class' => 'btn btn-primary mr-auto', 'data-dismiss' => 'modal']);
        $footer .= Html::a(Yii::t('app', 'Place an order'), ['/bag/index'], ['class' => 'btn btn-warning']);
        $cart = Cart::getCart();
        $variant_ids = array_keys($cart);

        $items = Variant::find()->where(['id' => $variant_ids])->andWhere(['enabled' => true])->all();

        $data = [
            'title' => Yii::t('app', 'Your Cart Items'),
            'body' => $this->renderAjax('offcanvas', [
                'items' => $items,
                'cart' => $cart,
            ]),
            'footer' => $footer,
            'dialog' => 'modal-lg',
        ];
       
        return Json::encode($data);
    }


    /**
     * @return string
     * @throws \Exception
     */
    public function actionBlock()
    {
        return CartWidget::widget();
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionDel($id)
    {
        $cart = Cart::getCart();

        ArrayHelper::remove($cart, $id);

        return Cart::setCart($cart);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionAdd($id)
    {
        $cart = Cart::getCart();

        ArrayHelper::setValue($cart, $id, ArrayHelper::getValue($cart, $id) + 1);

        return Cart::setCart($cart);
    }

    /**
     * @param $id
     * @param $count
     * @return bool
     */
    public function actionSet($id, $count)
    {
        $cart = Cart::getCart();

        $cart[$id] = $count;

        return Cart::setCart($cart);
    }
}
