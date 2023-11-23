<?php

/**
 * View file for block: GroupBlock
 *
 * File has been created with `block/create` command on LUYA version 1.0.0.
 *
 * @param $this->varValue('elements');
 *
 * @var $this \luya\cms\base\PhpBlockView
 */

//\siripravi\catalog\frontend\assets\Main::register(Yii::$app->view);

?>

<!-- New Code begin  -->
<div class="categories">
    <div class="container">
        <div class="row">
            <div class="col-md-12 heading">
                <h2>Like sweets?</h2>
                <p class="hidden-xs">Good! We got lots of - and more.</p>
                <p class="visible-xs">Browse our categories</p>
            </div>
        </div>
        <div class="row types">
            <?php foreach ($this->extraValue('elements')['categories'] as $key => $element) : ?>
                <div class="col-sm-3 col-xs-6 col">
                    <a data-category="<?= $element->slug; ?>" href="/menu/<?= $element->slug; ?>">
                        <img class="img-fluid img-responsive" src="<?= Yii::$app->storage->getImage($element->cover_image_id)->source ?>" alt="">
                        <span class="name"><?= $element->name; ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>