<?php

namespace app\modules\catalog\admin\apis;

/**
 * Product Set Ref Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class ProductSetRefController extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'app\modules\catalog\models\ProductSetRef';
}