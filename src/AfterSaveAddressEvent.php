<?php

namespace siripravi\catalog;

use luya\forms\models\Form;
use siripravi\catalog\AddressModel;
use yii\base\Event;

/**
 * A form after save event to attach in the config.
 * 
 * ```php
 * 'forms' => [
 *     'class' => 'luya\forms\Forms',
 *     'on afterSave' => function(\luya\forms\AfterSaveEvent $event) {
 *         // do something with event model 
 *     }
 * ]
 * ```
 * 
 * @since 1.6.0
 */
class AfterSaveAddressEvent extends Event
{
    /**
     * @var SubmissionEmail
     */
    public $submission;

    /**
     * @var Form
     */
    public $form;
    public $model;

    private $_model;

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param Model $form
     */
    public function setModel(AddressModel $model)   {
        $this->_model= $model;
    }
}