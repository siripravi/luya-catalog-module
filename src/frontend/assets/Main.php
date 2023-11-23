<?php

namespace siripravi\catalog\frontend\assets;


class Main extends \luya\web\Asset
{
    public $sourcePath = '@catalog/resources';

    public $js = [
        'js/main.js',
    ];

    public $css = [
        'css/bootstrap.min.css',
        'css/style.css',
    ];

    public $depends = [
        'luya\admin\assets\Jquery',
    ];
}
