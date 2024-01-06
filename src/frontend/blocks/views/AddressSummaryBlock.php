<?php

use yii\helpers\Url;
use yii\helpers\Html;

$model = $this->extraValue('summary');
?>
<div style="padding-right: 0;">

    <div class="card">
        <?= Html::a('Edit',  Yii::$app->request->referrer); ?>
        <fieldset disabled>
            <?php echo "<pre>";
            print_r($model->attributes);
            echo "</pre>";
            ?>
        </fieldset>
    </div>
</div>
<?php
       /*
foreach ($model->attributes as $k => $v) {
            if ($model->isAttributeInvisible($k)) {
                continue;
            }
            $html .= StringHelper::template($this->getVarValue('template', $this->template), [
                'label' => $model->getAttributeLabel($k),
                'value' => $model->formatAttributeValue($k, $v),
            ]);
        }
*/