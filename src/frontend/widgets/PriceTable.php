<?php

/**
 * Created by PhpStorm.
 * User: dench
 * Date: 20.01.18
 * Time: 13:01
 */

namespace siripravi\catalog\frontend\widgets;

use siripravi\catalog\models\Article;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

class PriceTable extends Widget
{
    public $id;

    public $article;

    public $urlCartAdd = ['/cart/bag/add'];

    public $options = [];

    public $originalPrice = false;

    public $available;

    public $value_ids;
    public $list;
    public $feature_id;
    public $feature_name;
    public function run()
    {
        /** @var $articles Variant[] */
        $variant = "";
        $value_ids = [];
        $list = [];
        $feature_id = null;
        $feature_name = "";
        if ($this->article->enabled) {
            $variant = $this->article;
            $value_ids = $this->value_ids;
            $list = $this->list;
            $feature_id = $this->feature_id;
            $feature_name = $this->feature_name;
        }
        foreach ($value_ids as $vid) {
        }
        $this->registerClientScript();


        $priceList = $variant->getPricesDef($feature_id);
        echo "<div class='row'><div class='col-md-12'>";
        echo "<label>" . $feature_name . "</label>";
        echo "<div class='styled-select decoration'>";
        echo Html::dropDownList(
            'buy[' . $variant->product_id . '][2]',
            "",
            ArrayHelper::map($priceList, "price", "priceLabel")
            //['value' => $variant->id]) . ' ' . $variant->name, ['class' => $availableClass

        );
        echo "</div></div></div>";
    }

    private function registerClientScript()
    {
        $url_add = Url::to($this->urlCartAdd);

        $url_cart_modal = Url::to(['/bag/offcanvas']);

        $js = <<< JS
var eq = 0;
$('.table-price tr').each(function(index){
    var obj = $(this).parents('table');
    $(this).find('td').mouseenter(function(){
        var i = $(this).index();
        obj.find('tr').each(function(){
            $(this).find('td').eq(i-1).addClass('over');
        });
    }).mouseleave(function(){
        var i = $(this).index();
        obj.find('tr').each(function(){
            $(this).find('td').eq(i-1).removeClass('over');
        });
    }).click(function(){
        var i = $(this).index();
        obj.find('tr').each(function(index3){
            $(this).find('input').prop('checked', false);
            $(this).find('td').removeClass('active').eq(i-1).each(function(){
                if (index3) {
                    var oo = obj.closest('.row').parent().closest('.row');
                    var o = $(this).find('.available');
                    if (o.hasClass('not-available')) {
                        oo.find('.btn-buy').hide();
                    } else if (o.hasClass('in-stock')) {
                        oo.find('.btn-buy').show().text(o.attr('rel'));
                    } else if (o.hasClass('on-order')) {
                        oo.find('.btn-buy').show().text(o.attr('rel'));
                    }
                    oo.find('.stock').html(o.clone().removeClass('d-none'));
                }
            }).addClass('active').find('input').prop('checked', true);
        });
    }).each(function(index2){
        if (!index && !eq && $(this).hasClass('in-stock')) {
            eq = index2;
            return false;
        }
    }).eq(eq).addClass('active').find('input').prop('checked', true);
    if (index) {
        eq = 0;
    }
});
$('.btn-buy').mousedown(function(){
    var id = $('#' + $(this).attr('rel') + ' input:checked').val();
    $.get('{$url_add}', { id: id }, function(){
        //openModal('{$url_cart_modal}');
        openOffCanvas('{$url_cart_modal}');
    });
});
JS;
        $this->view->registerJs($js, View::POS_READY, 'jsPriceTable');
    }
}
