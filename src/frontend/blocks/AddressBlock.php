<?php

namespace siripravi\catalog\frontend\blocks;
use luya\forms\FieldBlockTrait;
use siripravi\catalog\AddressModel;
use luya\helpers\ArrayHelper;

class AddressBlock extends FormBlock
{
    use FieldBlockTrait;

    public function name()
    {
        return 'Address selection';
    }

    public function admin()
    {
        return '<p>Address Selection {{vars.label}}</p>';
    }

    public function extraVars()
    {
        return [
            //'addressList' => $this->getAddressList()
        ];
    }
     /**
     * @inheritDoc
     */
   

    public function frontend()
    {
        \Yii::$app->forms->autoConfigureAttribute(
            $this->getVarValue($this->varAttribute),
            $this->getVarValue($this->varRule, $this->defaultRule),
            $this->getVarValue($this->varIsRequired),
            $this->getVarValue($this->varLabel),
            $this->getVarValue($this->varHint)
        );
        $output = '';
        $selected = [];       
        $model = \Yii::$app->forms->model;
        $model->addressList = $this->getAddressList();  //getextraValue('addressList');
         $selected = ArrayHelper::typeCast(\Yii::$app->session->get('__formData', $model->attributes));            
         $output .= \Yii::$app->forms->form->field($model,'Aid')->hiddenInput()->label(false);
      //  $addressList = $this->getA();
      /*  echo "<pre>";
        print_r($model->addressList);
        echo "</pre>"; */  //die;
        //$model->Aid = ($selected['Aid']) ? $selected['Aid'] : '';
       // $output .= "<h5>" . $feature->name . "-" . $feature->id . "</h5>";
        $output .= "<div class='addrSel'>";
        $output .= "<div class='d-flex flex-wrap align-content-start'>";
        $output .= \Yii::$app->forms->form->field(
                    $model, 'addressList',
                   // $this->getVarValue($this->varAttribute)
                )
                ->radioList( $model->addressList,
                   // ArrayHelper::map($addressList, "id", "address"),
                    [
                        'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                            $check = ($index == 0 && $value > 0) ? 'checked' : '';
                            $checked = ($model->Aid == $value) ? 'checked' : $check;
                            $return = '<div class="p-2 flex-fill">';
                            $return .= '<input type="radio" id="' . $name . $index . '" class="btn-check" data-ftext="' . $label . '" name="' . $name . '" value="' . $value . '" title="click" autocomplete="off" ' . $checked . '>';
                            $return .= '<label class="btn btn-outline-primary" for="' . $name . $index . '">' . '<i class="bi bi-circle pe-2" style="font-size:20px;"></i><span class="text-muted">' . ucwords($label) . '</span></label>';
                            $return .= "</div>";
                            return $return;
                        }, 'class' => 'd-flex text-inline'
                    ],
                )->label(false);
        $output .=  "</div>";
        $output .=  "</div>";
        return $output;
    }

    public function getAddressList()
    {
        $addressList = [];
        if(\Yii::$app->user->identity){
            $addre = \Yii::$app->user->identity->profile->userAddresses;
            foreach($addre as $adrs){
                $addressList[$adrs['id']] = AddressModel::renderAddress($adrs);
            }
        }
        return $addressList;
    }

}