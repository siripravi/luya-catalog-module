<?php

namespace siripravi\catalog;

use luya\Exception;
use luya\forms\models\Form;
use luya\forms\models\Submission;
use luya\forms\models\SubmissionValue;
use luya\forms\SubmissionEmail;
use luya\helpers\StringHelper;
use Yii;
use yii\widgets\ActiveForm;
use luya\forms\Model;

/**
 * Forms Component
 *
 * @property ActiveForm $form
 * @property Model $model
 *
 * @author Basil Suter <git@nadar.io>
 * @since 1.0.0
 */
class Forms extends \luya\forms\Forms
{
    const EVENT_AFTER_SAVE = 'afterSave';

    /**
     * @var ActiveForm
     */
    private $_form;

    /**
     * @var Model
     */
    private $_model;


    /**
     * Initialize the form and the model
     *
     * @param ActiveForm $form
     */

    public function startForm(ActiveForm $form)
    {
        $this->_form = $form;
        $this->_model = new Model();
    }
    public function beginForm(ActiveForm $form, String $model = 'luya\forms\Model')
    {
        $this->_model = new $model();
        $form->options = isset($this->_model->activeFormClassOptions) ? $this->_model->activeFormClassOptions : [];
        $this->_form = $form;

        $this->sessionFormDataName = "__" . $model;
    }

    /**
     * Active Form Getter
     *
     * @return ActiveForm
     */
    public function getForm()
    {
        return $this->_form;
    }

    public function setModel($model)
    {
        $this->_model = $model;
    }

    /**
     * Model Getter
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * Submit and Save the form and store the data
     *
     * @param Form $form
     * @param boolean $doNotSave Whether the form should really be saved, this can be enabled when sensitiv informations should not be stored
     * and just sent by email instead.
     * @return boolean Whether sending was succesful or not
     */
    public function save(Form $form, $doNotSave = false)
    {
        // echo $doNotSave; die;
        $model = new Submission();
        $model->form_id = $form->id;
        $model->useragent = Yii::$app->request->userAgent;
        $model->language = Yii::$app->composition->getLangShortCode();
        $model->url = Yii::$app->request->url;

        // error while saving
        if (!$model->save()) {
            return false;
        }

        foreach ($this->getFormData() as $attribute => $value) {
            if ($this->model->isAttributeInvisible($attribute)) {
                continue;
            }
            $submissionValue = new SubmissionValue();
            $submissionValue->submission_id = $model->id;
            $submissionValue->attribute = $attribute;
            $submissionValue->label = $this->model->getAttributeLabel($attribute);
            $submissionValue->hint = isset($this->model->attributeHints[$attribute]) ? $this->model->attributeHints[$attribute] : null;
            $submissionValue->value = $value;
            $submissionValue->format = isset($this->model->formatters[$attribute]) ? $this->model->formatters[$attribute] : null;
            $submissionValue->save();
        }

        $submissionEmail = new SubmissionEmail($model);

        // if no recipients are defined, the form wont trigger an email
        // and therefore succeed.
        if (empty($submissionEmail->getRecipients())) {
            return true;
        }
        try {
            if ($this->emailMessage) {
                return call_user_func($this->emailMessage, $submissionEmail, $this);
            } else {
                $mailer =  Yii::$app->mailer;
                $mailer->viewPath = "@app/mail";
                $view = 'form';
                $mail =  Yii::$app->mailer
                    ->compose(
                        ['html' => $view, 'text' => 'text/' . $view],

                        [
                            'message' => StringHelper::template(
                                $this->defaultEmailTemplate,
                                [
                                    'intro' => nl2br($submissionEmail->getIntro()),
                                    'outro' => nl2br($submissionEmail->getOutro()),
                                    'summary' => $submissionEmail->getSummaryHtml()
                                ]
                            )
                        ]
                    )
                    ->setTo($submissionEmail->getRecipients())
                    ->setFrom('purnachandra.valluri@gmail.com')
                    ->setSubject($submissionEmail->getSubject())
                    ->send();
                /* $mail = Yii::$app->mailer
                    ->compose(
                        $submissionEmail->getSubject(),
                        StringHelper::template($this->defaultEmailTemplate, [
                            'intro' => nl2br($submissionEmail->getIntro()),
                            'outro' => nl2br($submissionEmail->getOutro()),
                            'summary' => $submissionEmail->getSummaryHtml()
                        ])
                    )
                    ->addresses($submissionEmail->getRecipients())
                    ->send();*/

                if (!$mail) {
                    throw new Exception(Yii::$app->mail->error);
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            if ($doNotSave) {
                $model->delete();
            }
        }
        return true;
    }
}
