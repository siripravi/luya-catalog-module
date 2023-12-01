<?php

namespace siripravi\catalog\frontend\controllers;

use siripravi\catalog\models\Group;
use siripravi\catalog\models\Article;
use Yii;
use yii\web\View;
use yii\web\NotFoundHttpException;
use Exception;
use luya\cms\frontend\base\Controller;
use luya\helpers\StringHelper;
use luya\cms\models\Redirect;
use siripravi\catalog\models\Cart;
use siripravi\catalog\models\Order;
use siripravi\catalog\models\OrderForm;
use siripravi\catalog\widgets\CartWidget;

class DefaultController extends Controller
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
     * @inheritdoc
     */
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $groups = Group::getMenu();
        $items = Article::getElements();

        return $this->render('index', [
            'groups' => $groups,
            'items' => $items
        ]);
    }

     /**
     * @return string|\yii\web\Response
     */
    public function actionCart()
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
                        $image = "";//Url::to(ImageHelper::thumb($product->image->id, 'micro'), 'https');
                    } elseif ($product->product->image) {
                        $image = "";//Url::to(ImageHelper::thumb($product->product->image->id, 'micro'), 'https');
                    }
                    $products[] = [
                        'imageUrl' => $image,
                        'url' => Url::to(['/catalog/product/index', 'slug' => $product->product->slug], 'https'),
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

        return $this->render('cart', [
          //  'page' => $page,
            'items' => $items,
            'cart' => $cart,
            'model' => $model,
            'notAvailable' => $notAvailable,
        ]);
    }

    /**
     * @return int Calculate the number of basket items
     */
    public function getBasketCount()
    {
        return 10;
    }

     /**
     * @return string
     */
    public function actionOffcanvas()
    {
        $footer = Html::button(Yii::t('app', 'Continue shopping'), ['class' => 'btn btn-primary mr-auto', 'data-dismiss' => 'modal']);
        $footer .= Html::a(Yii::t('app', 'Place an order'), ['cart'], ['class' => 'btn btn-warning']);
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
     * Returns all basket items for this user.
     */
    public function actionBasket()
    {
        // add your basket action logic
        return $this->renderLayout('basket', ['morning' => 'MORNING']);
    }

    /**
     * Display confirmation page.
     */
    public function actionConfirm()
    {
        // add your confirmation action logic
        return $this->renderLayout('confirm');
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
