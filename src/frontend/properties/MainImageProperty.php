<?php

namespace siripravi\catalog\frontend\properties;

use siripravi\catalog\frontend\Module;
use luya\admin\base\ImageProperty;

class MainImageProperty extends ImageProperty
{
    /**
     * @inheritDoc
     */
    public function varName()
    {
        return 'mainImage';
    }

    /**
     * @inheritDoc
     */
    public function label()
    {
        return Module::t('Main Image');
    }
}
