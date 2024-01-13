<?php

namespace siripravi\catalog\frontend\blocks;

use luya\cms\base\PhpBlock;
use siripravi\catalog\frontend\blockgroups\BlockCollectionGroup;
use luya\helpers\StringHelper;
use Yii;

/**
 * Summary
 *
 * @author Basil Suter <git@nadar.io>
 * @since 1.0.0
 */
class FeatureViewBlock extends PhpBlock //\app\blocks\FormBlock
{
    public $template = '<p>{{label}}: {{value}}</p>';
    public $previewButtonsTemplate = '<div class="forms-preview-buttons-container pt-3">{{back}}<span class="forms-divider"> | </span>{{submit}}</div>';

    public $isContainer = false;
    public $module = 'catalog';
    public function blockGroup()
    {
        return BlockCollectionGroup::class;
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'template', 'label' => Yii::t('forms', 'Row Template'), 'type' => self::TYPE_TEXTAREA, 'placeholder' => $this->template],
                [
                    'var' => 'formId',
                    'label' => Yii::t('forms', 'Form'),
                    'type' => self::TYPE_SELECT_CRUD,
                    'required' => true,
                    'options' => ['route' => 'forms/form/index', 'api' => 'admin/api-forms-form', 'fields' => ['title']]
                ],

            ]
        ];
    }

    public function getFieldHelp()
    {
        return [
            'template' => Yii::t('forms', 'The variables {{label}} and {{value}} are available.'),
        ];
    }

    public function admin()
    {
        return '<div class="alert alert-info border-0 text-center">Summary / Preview</div>';
    }

    public function name()
    {
        return 'Preview Features';  //Yii::t('forms', 'Summary');
    }


    /**
     * @inheritDoc
     */
    public function extraVars()
    {
        return [
            //'ajaxLink' => $this->createAjaxLink('HelloWorld', ['time' => time()]),
            //'articleId' => \Yii::$app->request->get('id'),
            'summary' => $this->getSummary()
        ];
    }

    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'description';
    }

    /* public function frontend(){
        //return parent->frontend();
        $model = Yii::$app->forms->model;
        return get_class($model);  //$this->varValue('formId');
    }*/
    public function getSummary()
    {
        Yii::$app->forms->loadModel();
        $html = null;
        $model = Yii::$app->forms->model;
        /*foreach ($model->attributes as $k => $v) {
            if ($model->isAttributeInvisible($k)) {
                continue;
            }
            $html .= StringHelper::template($this->getVarValue('template', $this->template), [
                'label' => $model->getAttributeLabel($k),
                'value' => $model->formatAttributeValue($k, $v),
            ]);
        }*/
        return $model;
    }
}
