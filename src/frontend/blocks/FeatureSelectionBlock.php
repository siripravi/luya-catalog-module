<?php

namespace siripravi\catalog\frontend\blocks;

use luya\forms\FieldBlockTrait;
use siripravi\catalog\models\Article;
use siripravi\catalog\models\Product;
use siripravi\catalog\models\Feature;
use app\blocks\FormBlock;
use luya\helpers\ArrayHelper;
use yii\helpers\Html;

class FeatureSelectionBlock extends FormBlock
{
    use FieldBlockTrait;

    public function name()
    {
        return 'Article Feat seln';
    }

    public function admin()
    {
        return '<p> Feature Selection
        <span class="block__empty-text">Feature Selection</span>       
        <header>
            <h3>
           <span class="block__empty-text">feature Sel</span>            
            </h3>
        </header>       
       
        </p>';
    }

    public function extraVars()
    {
        return [
            // 'features' => $this->getFeatures()
            'ajaxLink' => $this->createAjaxLink('HelloWorld', ['time' => time()]),
        ];
    }
    public function frontend()
    {
        \Yii::$app->forms->autoConfigureAttribute(
            $this->getVarValue($this->varAttribute),
            $this->getVarValue($this->varRule, $this->defaultRule),
            $this->getVarValue($this->varIsRequired),
            $this->getVarValue($this->varLabel),
            $this->getVarValue($this->varHint)
        );
        $output = '';
        $selected = [];
        $model = \Yii::$app->forms->model;
        $selected = ArrayHelper::typeCast(\Yii::$app->session->get('__ArticleFeatureModel', $model->attributes));
       
        $output .= '<div style="padding-right: 0;">';
        $output .= '<span style="vertical-align:super;font-size:31px; padding-right:5px;" class="moneySymbol">₹</span>';
        $output .= '<span class="price product-price moneyCal" data-inr="' . $model->Price . '" style="color: #fff; font-size: 48px; font-weight: 600;" id="productPrice">' . $model->Price . '</span>';
        $output .= '</div>';
        $featureList = $this->getArticlePrices();

        $output .= Html::hiddenInput('articlefeaturemodel-product', $featureList[0]['article_id'], ['id' => 'ProductId']);

        foreach ($featureList as $id => $feature) {
            switch ($feature['type']) {
                case 1:

                    $fId = $feature['id'];
                    $model->Features[$fId] = ($selected['Features']) ? $selected['Features'][$fId] : '';
                    $fArr = $feature['featureValues'][$fId];
                    $radList = ArrayHelper::map($fArr, "id", "name");
                    $output .= "<h5>" . $feature['name'] . "</h5>";
                    $output .= "<div class='featSel'>";
                    $output .= "<div class='card bg-info d-flex flex-wrap align-content-start'>";
                    $output .= \Yii::$app->forms->form->field(
                        $model,
                        $this->getVarValue($this->varAttribute) . '[' . $fId . ']'
                    )
                        ->radioList(
                            $radList,
                            [
                                'item' => function ($index, $label, $name, $checked, $value) use ($model, $fArr, $fId) {
                                    $check = ($index == 0 && $value > 0) ? 'checked' : '';
                                    $checked = ($model->Features[$fId] == $value) ? 'checked' : $check;
                                    $return = '<div class="p-2 flex-fill fsel">';
                                    $return .= '<input type="radio" id="' . $name . $index . '" class="btn-check" name="' . $name . '"data-ftext="' . $label . '_' . $fArr[$value]['price'] . '" value="' . $value . '" title="click" autocomplete="off" ' . $checked . '>';
                                    $return .= '<label class="btn btn-outline-primary" for="' . $name . $index . '">' . '<i class="bi bi-circle pe-2" style="font-size:20px;"></i><span class="xtext-muted">' . ucwords($label) . '@ ' . $fArr[$value]['price'] . '</span></label>';
                                    $return .= "</div>";
                                    return $return;
                                }, 'class' => 'd-flex text-inline'
                            ],

                        )->label(false);
                    $output .=  "</div>";
                    $output .=  "</div>";
            }
        }
        return $output;
    }
    public function getArticle()
    {
        $session = \Yii::$app->session;
        $id = \Yii::$app->request->get('id') ?  \Yii::$app->request->get('id') : $session['__params']['id'];
        return Article::findOne(['id' => $id, 'enabled' => 1]);
    }
    public function getArticlePrices()
    {
        $article = $this->getArticle();
        $product = Product::viewPage($article->product_id);
        $category_ids = $product->group_ids;
        $prices = $article->prices;
        $priceList = ArrayHelper::index(ArrayHelper::toArray($prices, [
            'siripravi\catalog\models\ArticlePrice' => [
                'article_id', 'value_id', 'currency_id', 'price', 'qty', 'unit_id'
            ],
        ]), 'value_id');
        $obList = Feature::find()->joinWith(['groups'])->andFilterWhere(['catalog_feature.enabled' => true])->andFilterWhere(['group_id' => $category_ids])->orderBy('position')->all();
        $pli =  ArrayHelper::toArray($obList, [
            'siripravi\catalog\models\Feature' => [
                'id',
                'name',
                'type',
                'input',
                // 'values',
                'featureValues',
                //  'DP',
            ],
        ]);
        array_walk($pli, function (&$value, $key) use ($priceList) {
            $fId = $value['id'];

            $fVals = (array_key_exists($fId, $value['featureValues'])) ? $value['featureValues'][$fId] : [];
            foreach ($fVals as $k => $v) {
                if (array_key_exists($k, $priceList)) {
                    if (!empty($v)) {
                        $value['article_id'] = $priceList[$k]['article_id'];
                        $value['featureValues'][$fId][$k]['value_id'] = $priceList[$k]['value_id'];
                        $value['featureValues'][$fId][$k]['currency_id'] = $priceList[$k]['currency_id'];
                        $value['featureValues'][$fId][$k]['price'] = $priceList[$k]['price'];
                        $value['featureValues'][$fId][$k]['qty'] = $priceList[$k]['qty'];
                        $value['featureValues'][$fId][$k]['unit_id'] = $priceList[$k]['unit_id'];
                    }
                } else {
                    unset($value['featureValues'][$fId][$k]);
                }
            }
        });

        return $pli;
    }

    public function callbackHelloWorld($time)
    {
        return 'hallo world ' . $time;
    }
}
