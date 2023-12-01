<?php

namespace app\modules\cart\actions;

use app\modules\cart\models\Delivery;
use Yii;
use yii\base\Action;

class DeliveryAction extends Action
{
    public function run()
    {
        $id = Yii::$app->request->post('id');

        if ($model = Delivery::findOne($id)) {
            return $this->controller->renderAjax('delivery', [
                'model' => $model,
            ]);
        } else {
            return null;
        }
    }
}
