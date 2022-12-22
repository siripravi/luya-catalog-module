<?php
/**
 * View file for block: HeadTeaserBlock 
 *
 * File has been created with `block/create` command on LUYA version 1.0.0-RC3. 
 *
 *
 * @var $this \luya\cms\base\PhpBlockView
 */

 use yii\widgets\ListView;
?>

<?php
    //echo Yii::$app->controller->module->getViewPath();die;
    echo ListView::widget([
        'dataProvider' => $this->extraValue('elements')['dataProvider'],
        'itemView' => '@catalog/views/blocks/_item',
         'layout' => '
		 <div class="row featured">{items}</div>',
        'emptyTextOptions' => [
            'class' => 'alert alert-danger',
        ],
       'options' => ['class' => 'products home-products container'],
        'itemOptions' => [
            'class' => 'col-sm-6 col',
        ]
    ]);
			
    ?>