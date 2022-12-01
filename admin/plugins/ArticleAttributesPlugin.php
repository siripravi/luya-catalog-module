<?php

namespace app\modules\eshop\admin\plugins;

use luya\admin\ngrest\base\Plugin;

class ArticleAttributesPlugin extends Plugin
{
    public function renderList($id, $ngModel)
    {
        return $this->createListTag($ngModel);
    }
    
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('catalog-attributes', $id, $ngModel, ['product' => 'data.create.product_id']);
    }
    
    public function renderUpdate($id, $ngModel)
    {
        return $this->createFormTag('catalog-attributes', $id, $ngModel, ['product' => 'data.update.product_id']);
    }
}
