<?php

namespace app\modules\catalog\admin;
/**
 * Catalog Admin Module.
 *
 * File has been created with `module/create` command. 
 * 
 * @author
 * @since 1.0.0
 */
class Module extends \luya\admin\base\Module
{
    public $apis = [
        'api-catalog-group'         => 'app\modules\catalog\admin\apis\GroupController',
        'api-catalog-product'       => 'app\modules\catalog\admin\apis\ProductController',
        'api-catalog-set'           => 'app\modules\catalog\admin\apis\SetController',
      //  'api-catalog-articlevalueref'  => 'app\modules\catalog\admin\apis\ArticleValueRefController',
        'api-catalog-article'       => 'app\modules\catalog\admin\apis\ArticleController',
        'api-catalog-feature'          => 'app\modules\catalog\admin\apis\FeatureController',
        'api-catalog-brand'         => 'app\modules\catalog\admin\apis\BrandController',
        'api-catalog-currency'      => 'app\modules\catalog\admin\apis\CurrencyController',
        'api-catalog-unit'          => 'app\modules\catalog\admin\apis\UnitController',
        'api-catalog-producer'      => 'app\modules\catalog\admin\apis\ProducerController',
        'api-catalog-productrelated'=> 'app\modules\catalog\admin\apis\ProductRelatedController',
        'api-catalog-related'       => 'app\modules\catalog\admin\apis\RelatedController',
        'api-catalog-articleprice'     => 'app\modules\catalog\admin\apis\ArticlePriceController',
        'api-catalog-value'     => 'app\modules\catalog\admin\apis\ValueController',
        
    ];

    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
        ->node('Shop Catalog', 'local_mall')
            ->group('Products')
                ->itemApi('Groups', 'catalogadmin/group/index', 'folder', 'api-catalog-group')
                ->itemApi('Products', 'catalogadmin/product/index', 'library_books', 'api-catalog-product')
                ->itemApi('Articles', 'catalogadmin/article/index', 'list', 'api-catalog-article')
                ->itemApi('Related', 'catalogadmin/related/index', 'domain', 'api-catalog-related')
                ->itemApi('Prices', 'catalogadmin/article-price/index', 'adjust', 'api-catalog-articleprice')
            ->group('Settings')
                ->itemApi('Units', 'catalogadmin/unit/index', 'domain', 'api-catalog-unit')
                ->itemApi('Currencies', 'catalogadmin/currency/index', 'attach_money', 'api-catalog-currency')
                ->itemApi('Brands', 'catalogadmin/brand/index', 'auto_awesome_motion', 'api-catalog-brand')
            ->group('Sets')
               // ->itemApi('Sets', 'catalogadmin/article-value-ref/index', 'web_asset', 'api-articlevalueref')
                ->itemApi('Features', 'catalogadmin/feature/index', 'check_box', 'api-catalog-feature')
                ->itemApi('Values', 'catalogadmin/value/index', 'check_box', 'api-catalog-value');
                
    }

    public function getAdminAssets()
    {
        return [
            'app\modules\catalog\admin\assets\CatalogAdminAsset'
        ];
    }
}