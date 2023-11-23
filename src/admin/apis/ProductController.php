<?php

namespace siripravi\catalog\admin\apis;

use siripravi\catalog\models\Article;
use siripravi\catalog\models\Feature;
use siripravi\catalog\models\Value;
use siripravi\catalog\models\ArticleValueRef;
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
    public $modelClass = 'siripravi\catalog\models\Product';

    /**
     *
     * @param unknown $id
     * @return unknown
     */
    public function actionFeatures($id)
    {
        $features = [];
        $value_ids = [];
        $model = Article::find(['id' => $id])->one();
        $product = $model->product;
        $value_ids = ArticleValueRef::getList($id); //["28", "29", "30"];  //$model->value_ids;
        //  print_r($value_ids); die;
        if ($product->group_ids)
            $features = Feature::getObjectList(true, $product->group_ids);
        else
            $features = [];
        $list = [];

        /*foreach ($features as $set) {
            foreach ($model->value_ids as $value_id) {
                if (in_array($value_id,$list)) {
                    $value_ids[] = $value_id;
                }
            }       
        }*/
        $data = [];
        $featureVals = [];
        /* $list = ArticleValueRef::getList($id);
        foreach ($model->value_ids as $value_id) {
            if (in_array($value_id,$list)) {
                $value_ids[] = $value_id;
            }
        }   */
        foreach ($features as $set) {

            $featureVals[] = [
                'set' => $set,
                'attributes' => Value::getList($set->id), //foreach ($list as $i=> $item){
                'preSel'  => $value_ids
            ];
        }
        $data['fVals'] = $featureVals;
        $data['preSel'] = array_values($value_ids);
        $data['selected'] = $this->setAttributes($value_ids, $model->getValues());  //($value_ids);
        return $data;
    }

    public function setAttributes($value_ids, $featurs)
    {
        $data = [];
        foreach ($featurs as $key => $value) {
            $keys = array_keys($value);
            foreach ($keys as $k) {
                if (in_array($k, $value_ids)) {
                    $data[$key][$k] = 1;
                }
            }
        }
        // print_r($list);die;
        return $data;
    }
}
