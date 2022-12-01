<?php

namespace app\modules\eshop\admin\assets;

use luya\web\Asset;

class EshopAdminAsset extends Asset
{
    public $sourcePath = '@eshopadmin/resources';
    
    public $js = [
        'estoreAttributes.js',
    ];
    
    public $depends = [
        'luya\admin\assets\Main',
    ];
}
