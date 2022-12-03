<?php

namespace app\modules\catalog\admin\assets;

use luya\web\Asset;

class CatalogAdminAsset extends Asset
{
    public $sourcePath = '@catalogadmin/resources';
    
    public $js = [
        'articleFeatures.js',
    ];
    
    public $depends = [
        'luya\admin\assets\Main',
    ];
}
