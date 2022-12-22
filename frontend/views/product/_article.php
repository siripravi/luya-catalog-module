<?php


?>
<div class="row">
<!--?php foreach ($modelsVariant as $index => $modelVariant) : ?-->
    <div class="col-4 variant-item" data-position="<?= $modelVariant->position ?>" data-key="<?= $modelVariant->id ?>">
        <div class="photo">
            <?php if ($modelVariant->image_id) { ?>
                <a class="gallery-item" href="<?=  Yii::$app->storage->getImage($modelVariant->image_id)->source ?>" data-size="500X400">
                    <img class="img-fluid" src="<?= Yii::$app->storage->getImage($modelVariant->image_id)->source; ?>" alt="<?= $modelVariant->name ?>" title="<?= $modelVariant->name ?>">
                </a>
            <?php } else { ?>
                <div class="thumbnail">
                    <img class="img-fluid" src="/img/photo-default.png" alt="photo-default">
                </div>
            <?php } ?>
        </div>    
    </div>
    <div class="col-6">
         <?= $this->render('_price', [
            'model' => $modelVariant,
           // 'rating' => $rating
        ]) ?>   
    
    </div>
</div>    
        <!--?= $this->render('_text', [
            'name' => $model->name,
            'text' => $model->text,
        ]) ?-->
        <!--?= $this->render('_price', [
            'model' => $model,
           // 'rating' => $rating
        ]) ?-->   
        
    
<!--?php endforeach; ?-->
