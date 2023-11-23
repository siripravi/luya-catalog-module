<?php

namespace siripravi\catalog\frontend\properties;

use siripravi\catalog\frontend\Module;
use luya\admin\base\Property;

class PrimaryColorProperty extends Property
{
    /**
     * @inheritDoc
     */
    public function varName()
    {
        return 'primaryColor';
    }

    /**
     * @inheritDoc
     */
    public function label()
    {
        return Module::t('Primary Color');
    }

    /**
     * @inheritDoc
     */
    public function type()
    {
        return self::TYPE_COLOR;
    }
}
