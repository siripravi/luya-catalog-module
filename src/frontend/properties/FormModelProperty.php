<?php
namespace siripravi\catalog\frontend\properties;

class FormModelProperty extends \luya\admin\base\Property
{
    public function varName()
    {
        return 'model';
    }

    public function label()
    {
        return 'Model Class Name';
    }

    public function type()
    {
        return self::TYPE_TEXT;
    }
}
