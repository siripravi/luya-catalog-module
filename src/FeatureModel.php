<?php

namespace siripravi\catalog;

use luya\base\DynamicModel;
use app\modules\cart\models\Cart;
use yii\helpers\ArrayHelper;
use luya\helpers\StringHelper;
use Yii;

/**
 * Form Submission Model
 *
 * @author Basil Suter <git@nadar.io>
 * @since 1.0.0
 */
class FeatureModel extends \luya\forms\Model
{
    /**
     * @var string The uniue form id
     */
    public $formId;
    public $Pid;
    public $Features = [];
    public $Price;
    public $FeatureText;

    public $redirectUrl = "/shopping-cart";

    public $activeFormClassOptions = ['id' => 'cart-form'];
    /**
     * @var array An array where the key is the attribute and value the formatter option, like
     * ```php
     * 'firstname' => 'ntext',
     * ```
     */
    public $formatters = [];
    const EVENT_AFTER_SAVE = 'afterSave';

    public function init()
    {
        parent::init();

        //bind after confirmation event
        $this->on(
            self::EVENT_AFTER_SAVE,
            [
                new \siripravi\catalog\AfterSaveHandler(),
                'handleAfterSave',
            ]
        );
    }
    /**
     * Format a given attribute
     *
     * @param string $attribute
     * @param string $value
     * @return string
     */
    public function formatAttributeValue($attribute, $value)
    {
        $value = is_array($value) ? implode(", ", $value) : $value;

        if (isset($this->formatters[$attribute]) && !empty($this->formatters[$attribute])) {
            return Yii::$app->formatter->format($value, $this->formatters[$attribute]);
        }
        return Yii::$app->formatter->autoFormat($value);
    }

    private $_invisibleAttributes = [];

    /**
     * An invisible attribute will not be shown in the confirm page
     * nor the value will be stored when saving the form data.
     *
     * The invisible attributes won't be validated when switching from "confirm"
     * step to "save" step, the invisble attributes will only validate from "form input"
     * to "confirm" step. The main reason for this and also for introduction of invisible
     * attributes are captcha codes. They need to be validated once, afterwards they are
     * not valid anymore and should therfore not be validated in a second process.
     *
     * @param string $attributeName
     */
    public function invisibleAttribute($attributeName)
    {
        $this->_invisibleAttributes[] = $attributeName;
    }

    /**
     * Whether the given attribute is in the list of invisible attributes.
     *
     * @param string $attributeName
     * @return boolean
     */
    public function isAttributeInvisible($attributeName)
    {
        return in_array($attributeName, $this->_invisibleAttributes);
    }

    /**
     * Returns all attribute names without the attributes tagged as invisible
     *
     * @return array
     */
    public function getAttributesWithoutInvisible()
    {
        $result = [];
        foreach ($this->attributes() as $attributeName) {
            if (!$this->isAttributeInvisible($attributeName)) {
                $result[] = $attributeName;
            }
        }
        return $result;
    }

    public static function saveCartCookie($model)
    {
        $id = implode("+", $model->Features);
        $ftext = $model->FeatureText;
        $pid = $model->Pid;
        $price = $model->Price;
        $cart = Cart::getCart();

        if (isset($cart[$id])) {
            return false;
        }
        $qty = isset($cart[$id]) ? $cart[$id]["qty"] + 1 : 1;
        ArrayHelper::setValue($cart, $id, ["qty" =>  $qty, "pid" => $pid, "ftext" => $ftext, "price" => $price]);
        Cart::setCart($cart);
    }

    public static function getAfterSaveEvent(\siripravi\catalog\FeatureModel $model)
    {
        return \Yii::createObject(['class' => \siripravi\catalog\AfterSaveEvent::class, 'model' => $model]);
    }

    /* 6-inch-5-layer_36_2354+Eggless_31_251  */
    public function formatFText($ftext)
    {
        $words = [];
        $wor = StringHelper::explode($ftext, "+");
        if(count($wor) > 0){
        foreach ($wor as $i => $word) {
            $words[$i] = StringHelper::explode($word, "_");
        }
    }
        return $words;
        // ArrayHelpers::map($words,)
    }
}
