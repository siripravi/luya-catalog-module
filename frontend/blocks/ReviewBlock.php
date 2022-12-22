<?php

namespace app\modules\catalog\frontend\blocks;


use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;
use app\modules\catalog\models\Brand;
use luya\cms\injectors\ActiveQueryCheckboxInjector;
/**
 * Portfolio Block.
 *
 * File has been created with `block/create` command on LUYA version 1.0.0. 
 */
class ReviewBlock extends PhpBlock
{
   // public $isContainer = true;

    /**
     * @var string The module where this block belongs to in order to find the view files.
     */
    public $module = 'catalog';

    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return ProjectGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'Review';
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'image'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'cfgs' => [
                ['var' => 'images', 'label' => 'Images', 'type' => self::TYPE_IMAGEUPLOAD_ARRAY, 'options' => ['no_filter' => false]],
                ['var' => 'client_name','label' => 'Client Name', 'type' =>self::TYPE_TEXT],
                ['var' => 'profession','label' => 'Profession', 'type' =>self::TYPE_TEXT],
                ['var' => 'review', 'label' => 'The Text', 'type' => self::TYPE_TEXTAREA],
                ['var' => 'sel', 'label' => 'Selected', 'type' => self::TYPE_TEXT],
            ],
            'placeholders' => [
                [
                    ['var' => 'left', 'cols' => 8, 'label' => 'Left'],
                    ['var' => 'right', 'cols' => 4, 'label' => 'Right'],
                ]
            ],
        ];
    }

     /**
     * @inheritDoc
     */
    public function extraVars()
    {
        return [
            'images' => BlockHelper::imageArrayUpload($this->getCfgValue('images'), false, true),
            'txtClient' =>  $this->getVarValue('client_name'),
            'tarReview' => $this->getVarValue('mytext'),
        ];
    }

    /**
     * {@inheritDoc} 
     *
     * @param {{vars.elements}}
    */
    public function admin()
    {
        return '<h5 class="mb-3">Reviews</h5>' .
            '<table class="table table-bordered">' .
            '{% if cfgs.images is not empty %}' .
            '<tr><td><b>Clients</b></td><td>{{cfgs.images}}</td></tr>' .
            '{% endif %}'.
            '</table>';
    }

     /**
     * {@inheritdoc}
     */
   /* public function getViewPath()
    {
        return  dirname(__DIR__).'/src/views/blocks';
    }  */

    public function injectors(){
        
        return [
            'foobar' => new ActiveQueryCheckboxInjector([
                'query' => Brand::find(),//->where(['id' => 1]),
                'type' => self::INJECTOR_VAR, // could be self::INJECTOR_CFG,
                'varName' => 'sel',
                'varLabel' => 'The Field Label',
            ])
        ];
    }
}

