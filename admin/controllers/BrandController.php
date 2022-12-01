<?php

namespace app\modules\catalog\admin\controllers;

/**
 * Brand Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class BrandController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'app\modules\catalog\models\Brand';
}