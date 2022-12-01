<?php

namespace app\modules\catalog\admin\controllers;

/**
 * Currency Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class CurrencyController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'app\modules\catalog\models\Currency';
}