<?php

namespace siripravi\catalog\frontend\blocks;

use luya\forms\FieldBlockTrait;
use siripravi\catalog\models\Article;
use siripravi\catalog\models\Product;
use siripravi\catalog\models\Feature;
use luya\helpers\ArrayHelper;
use yii\helpers\Html;

class FeatureBlock extends FormBlock
{
    use FieldBlockTrait;

    public function name()
    {
        return 'Feature selection';
    }

    public function admin()
    {
        return '<p>Article {{vars.label}}</p>';
    }

    public function extraVars()
    {
        return [
            // 'features' => $this->getFeatures()
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
        $article = $this->getArticle();
        $features = $this->getFeatures($article->product_id);
        $model = \Yii::$app->forms->model;
        $model->Pid = $article->id;
        $elected['Features'] = [];
        $selected = ArrayHelper::typeCast(\Yii::$app->session->get('__formData', $model->attributes));
       
      /*  $output .= '<div style="padding-right: 0;">';
        $output .= '<span style="vertical-align:super;font-size:31px; padding-right:5px;" class="moneySymbol">₹</span>';
        $output .= '<span class="price product-price moneyCal" data-inr="' . $article->price . '" style="color: #fff; font-size: 48px; font-weight: 600;" id="productPrice">' . $article->price . '</span>';
        $output .= '</div>';  */
        $output .= Html::hiddenInput('featuremodel-product', $article->id, ['id' => 'ProductId']);
        foreach ($features as $id => $feature) {
            switch ($feature->type) {
                case 1:
                    $priceList = $article->getPricesDef($feature->id);
                    $model->Features[$id] = ($selected['Features']) ? $selected['Features'][$id] : '';
                    $output .= "<h5>" . $feature->name . "-" . $feature->id . "</h5>";
                    $output .= "<div class='featSel'>";
                    $output .= "<div class='d-flex flex-wrap align-content-start'>";
                    $output .= \Yii::$app->forms->form->field(
                        $model,
                        $this->getVarValue($this->varAttribute) . '[' . $id . ']'
                    )
                        ->radioList(
                            ArrayHelper::map($priceList, "price", "ftext"),
                            [
                                'item' => function ($index, $label, $name, $checked, $value) use ($model, $id) {
                                    $check = ($index == 0 && $value > 0) ? 'checked' : '';
                                    $checked = ($model->Features[$id] == $value) ? 'checked' : $check;
                                    $return = '<div class="p-2 flex-fill fsel">';
                                    $return .= '<input type="radio" id="' . $name . $index . '" class="btn-check" data-ftext="' . $label . '" name="' . $name . '" value="' . $value . '" title="click" autocomplete="off" ' . $checked . '>';
                                    $return .= '<label class="btn btn-outline-primary" for="' . $name . $index . '">' . '<i class="bi bi-circle pe-2" style="font-size:20px;"></i><span class="xtext-muted">' . ucwords($label) . '</span></label>';
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

    public function getFeatures($pid)
    {
        $features = [];
        $product = Product::viewPage($pid);
        $features = Feature::getObjectList(true, $product->group_ids);
        return $features;
    }
}
