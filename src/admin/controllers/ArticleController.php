<?php

namespace siripravi\catalog\admin\controllers;

/**
 * Article Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class ArticleController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'siripravi\catalog\models\Article';

    /**
     *
     * @param unknown $id
     * @return unknown
     */

    public function actionArticleFeatures()
    {
        return $this->render('articlefeature');
    }
}
