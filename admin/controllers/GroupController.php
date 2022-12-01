<?php

namespace app\modules\catalog\admin\controllers;

/**
 * Group Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class GroupController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'app\modules\catalog\models\Group';
}