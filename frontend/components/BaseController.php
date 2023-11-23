<?php

/**
 * User: TheCodeholic
 * Date: 12/12/2020
 * Time: 7:04 PM
 */

namespace siripravi\catalog\frontend\components;


use common\models\CartItem;
use frontend\models\Search;

/**
 * Class Controller
 *
 * @author  
 * @package 
 */
class BaseController extends \luya\web\Controller
{
    // public $layout = '@app/themes/escapeVelocity/views/layouts/detail';
    public $secClass = "container my-2 my-md-3";
    public $bannerTitle = "Some Title";
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }
}
