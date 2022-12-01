<?php

namespace app\modules\catalog\admin\controllers;

/**
 * Article Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class ArticleController extends \luya\admin\ngrest\base\Controller
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'app\modules\catalog\models\Article';

    /**
     *
     * @param unknown $id
     * @return unknown
     */
    public function actionAttributes($id)
    {
        $model = $this->findModel($id);
        
        $data = [];
        
        foreach ($model->getSets()->with(['setAttributes'])->all() as $set) {
            $data[] = [
                'set' => $set,
                'attributes' => $set->setAttributes,
            ];
        }
        
        return $data;
    }
}