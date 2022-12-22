<?php

namespace app\modules\catalog\admin\apis;

/**
 * Related Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class RelatedController extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'app\modules\catalog\models\Related';
}