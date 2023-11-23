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

class DefaultController extends Controller
{
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
     * @return int Calculate the number of basket items
     */
    public function getBasketCount()
    {
        return 10;
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
}
