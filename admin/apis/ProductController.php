<?php

namespace app\modules\catalog\admin\apis;

use app\modules\catalog\models\Article;
use app\modules\catalog\models\Feature;
use app\modules\catalog\models\Value;
use yii\helpers\JSON;
/**
 * Product Controller.
 * 
 * File has been created with `crud/create` command. 
 */
class ProductController extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'app\modules\catalog\models\Product';

    /**
     *
     * @param unknown $id
     * @return unknown
     */
    public function actionFeatures($id)
    {
        $features = [];
        $model = Article::find(['id'=>$id])->one();
        $product = $model->product;
        if($product->group_ids) 
           $features = Feature::getObjectList(true, $product->group_ids);
        else
           $features = [];   
       
        $data = [];        
        foreach ($features as $set) {
            $data[] = [
                'set' => $set,
                'attributes' => Value::getList($set->id),
            ];
        }        
        return $data;
    }

    public function setAttributes($feature_id){
        $value_ids = [];
        $list = Value::getList($feature->id);
        foreach ($modelVariant->value_ids as $value_id) {
            if (isset($list[$value_id])) {
                $value_ids[] = $value_id;
            }
        }
    }
}