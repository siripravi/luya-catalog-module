<?php

namespace siripravi\catalog\admin\apis;

/**
 * Feature Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class FeatureController extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'siripravi\catalog\models\Feature';
}
