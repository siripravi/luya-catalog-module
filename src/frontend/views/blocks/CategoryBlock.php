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
<!--
<div class="col mb-5">
    <div class="card h-100">
        
        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
      
        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="...">
     
        <div class="card-body p-4">
            <div class="text-center">
               
                <h5 class="fw-bolder">Special Item</h5>
              
                <div class="d-flex justify-content-center small text-warning mb-2">
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                </div>
             
                <span class="text-muted text-decoration-line-through">$20.00</span>
                $18.00
            </div>
        </div> 
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
        </div>
    </div>
</div> -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="section-title position-relative text-center mx-auto mb-5 pb-3" style="max-width: 600px;">
            <h2 class="text-primary font-secondary">Our Menu</h2>
            <h1 class="display-4 text-uppercase">We Sell These</h1>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($this->extraValue('elements')['categories'] as $key => $element) : ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <a data-category="<?= $element->slug; ?>" href="/menu/<?= $element->slug; ?>">
                            <img class="card-img-top" src="<?= Yii::$app->storage->getImage($element->cover_image_id)->source ?>" alt="" height="230">
                           
                        </a>
                        <div class="card-body p-4">
                            <div class="text-center">
                            <h5 class="name"><?= $element->name; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>