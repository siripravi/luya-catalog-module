<?php

namespace app\modules\catalog\admin\assets;

class CatAdminAsset extends \luya\web\Asset
{
    public $sourcePath = '@catalogadmin/resources';

    public $js = [
        'js/catalog.js',
    ];

    // important to solve all JavaScript dependency issues here, e.g. jQuery, bower, angular, ...
    public $depends = [
        'luya\admin\assets\Main',
    ];
}