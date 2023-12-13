<?php

namespace siripravi\catalog\admin;

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
        'api-catalog-group'         => 'siripravi\catalog\admin\apis\GroupController',
        'api-catalog-product'       => 'siripravi\catalog\admin\apis\ProductController',
        'api-catalog-set'           => 'siripravi\catalog\admin\apis\SetController',
        'api-catalog-featuregroupref' => 'siripravi\catalog\admin\apis\FeatureGroupRefController',
        //'api-catalog-articlevalueref'  => 'siripravi\catalog\admin\apis\ArticleValueRefController',
        'api-catalog-article'       => 'siripravi\catalog\admin\apis\ArticleController',
        'api-catalog-feature'          => 'siripravi\catalog\admin\apis\FeatureController',
        'api-catalog-brand'         => 'siripravi\catalog\admin\apis\BrandController',
        'api-catalog-currency'      => 'siripravi\catalog\admin\apis\CurrencyController',
        'api-catalog-unit'          => 'siripravi\catalog\admin\apis\UnitController',
        'api-catalog-producer'      => 'siripravi\catalog\admin\apis\ProducerController',
        'api-catalog-productrelated' => 'siripravi\catalog\admin\apis\ProductRelatedController',
        'api-catalog-related'       => 'siripravi\catalog\admin\apis\RelatedController',
        'api-catalog-articleprice'     => 'siripravi\catalog\admin\apis\ArticlePriceController',
        'api-catalog-value'     => 'siripravi\catalog\admin\apis\ValueController',

    ];

    public function getMenu()
    {
        return (new \luya\admin\components\AdminMenuBuilder($this))
            ->node('Shop Catalog', 'local_mall')
            ->group('Products')
            ->itemApi('Groups', 'catalogadmin/group/index', 'folder', 'api-catalog-group')
            ->itemApi('Group Features', 'catalogadmin/feature-group-ref/index', 'library_books', 'api-catalog-featuregroupref')
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
            'siripravi\catalog\admin\assets\CatalogAdminAsset'
        ];
    }
}
