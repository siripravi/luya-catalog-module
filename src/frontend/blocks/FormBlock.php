<?php

namespace siripravi\catalog\frontend\blocks;

use Yii;

use luya\Exception;
use luya\forms\blockgroups\FormGroup;
use luya\forms\Model;
use luya\forms\models\Form;

/**
 * Form Block.
 *
 * @author Basil Suter <git@nadar.io>
 * @since 1.0.0
 */
class FormBlock extends \luya\forms\blocks\FormBlock
{
    /**
     * @var string The module where this block belongs to in order to find the view files.
     */
    public $module = 'catalog';

    /**
     * @var boolean Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed
     * in a different way for a better user experience. Container block will not display isDirty colorizing.
     */
    public $isContainer = true;

    public $review = false;

    //public $previewButtonsTemplate = '<div class="forms-preview-buttons-container">{{back}}<span class="forms-divider"> | </span>{{submit}}</div>';
    public $previewButtonsTemplate = '{{submit}}';
    const EVENT_DANCE = 'dance';

    public function getViewFileName($extension)
{
    $className = get_class($this);
    $model = Yii::$app->menu->current->getPropertyValue('model');
    /*if (preg_match('/\\\\([\w]+)$/', basename($model), $matches)) {
        $model = $matches[1];
    }*/
    return basename($model).'Form.'.$extension;
}
    /**
     * {@inheritDoc}
     */
     
    public function setup()
    {
        // Yii::debug('from block setup invocation', __METHOD__);
        // echo $this->getEnvOption('context', false); die;
        $object = Yii::$app->forms->activeFormClass;
        $model = 'luya\forms\Model';
        if ($this->isFrontendContext())
            $model = Yii::$app->menu->current->getPropertyValue('model');
        // else if ($this->isAdminContext())
        // $model = $this->getEnvOption('pageObject')->navItem->nav->getProperty('model');

        // Yii::$app->forms->beginForm($object::begin(Yii::$app->forms->activeFormClassOptions),$model);
        Yii::$app->forms->model = new $model();
        // Yii::$app->forms->startForm($object::begin(Yii::$app->forms->activeFormClassOptions));
        //echo Yii::$app->menu->current->getPropertyValue('model'); die; 
        Yii::$app->forms->beginForm($object::begin(Yii::$app->forms->activeFormClassOptions), $model);
    }


    /**
     * Invokes the model submiting process and redirects the browsers if needed
     *
     * @return void
     */
    public function submitAndStore()
    {

        if ($this->isSubmit()) {
            // the data is only available if the isSubmit call was running, therefore for
            // first check for is submit
            // second get data from session
            $data = Yii::$app->forms->getFormData();
             /*  echo "<pre>";  print_r($data);
               echo "Before EVENT triggering...";
               die;*/
            if (!empty($data)) {
                /** @var Model $model */
                //$model = Yii::$app->forms->model;
                //  $mod = Yii::$app->menu->current->getPropertyValue('model');
                //  if($mod == null)
                //   $mod = $this->getEnvOption('pageObject')->navItem->nav->getProperty('model');
                //  $model = new $mod();
                $model = Yii::$app->forms->model;
                $model->attributes = $data;
                // invisible attributes should not be validate in the second validation step.
                if (Yii::$app->forms->isModelValidated || $model->validate($model->getAttributesWithoutInvisible())) {
                    if (!Yii::$app->forms->save(Form::findOne($this->getVarValue('formId')), $this->getCfgValue('doNotSaveData', false))) {
                        throw new Exception("Error while saving the form data, please try again later.");
                    }
                    $event = $model->getAfterSaveEvent($model);
                    
                    $model->trigger(get_class($model)::EVENT_AFTER_SAVE, $event);
                    Yii::$app->forms->cleanup();
                    // set flash, redirect and end app
                    Yii::$app->session->setFlash('formDataSuccess');
                    Yii::$app->response->redirect($model->redirectUrl);
                    // Yii::$app->response->redirect('/shopping-cart');
                    return Yii::$app->end();
                }
            }
        }
    }
}