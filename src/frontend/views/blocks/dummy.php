<div class="col-xs-12 col-lg-3 col-md-6 no-padding element_portfolio group<?= $element->groups[0]->id ?>" style="background-image: url('<?= $element->image_id->getSource() ?>');">
    <div class="portfolio-fade-in" style="background-color:<?= 'magenta' ?>" data-href="<!--?= $element->link ?-->" data-target="#exampleModal1" data-description="<?= $element->product->text ?>" data-img="<?= $element->image_id->getSource() ?>">
        <h1><?= $element->groups[0]->name ?></h1>
        <h2><?= strtoupper($element->name) ?></h2>
        <i class="fa fa-angle-right"></i>
    </div>
</div>

<!--  Group Block working View -->
<div class="container-xxl bg-light my-6 py-6 pt-0">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <p class="text-primary text-uppercase mb-2">// Bakery Products</p>
            <h1 class="display-6 mb-4">Explore The Categories Of Our Bakery Products</h1>
        </div>
        <div class="row g-4">
            <?php foreach ($this->extraValue('elements')['categories'] as $key => $element) : ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                    <div class="product-item d-flex flex-column bg-white rounded overflow-hidden h-100">
                        <div class="text-center p-4">
                            <div class="d-inline-block border border-primary rounded-pill px-3 mb-3">$11 - $99</div>
                            <h3 class="mb-3"><?= strtoupper($element->name) ?></h3>
                            <h5><?= $element->name ?></h5>
                            <span>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</span>
                        </div>
                        <div class="position-relative mt-auto">
                            <img class="img-fluid" src="<?= Yii::$app->storage->getImage($element->cover_image_id)->source ?>" alt="">
                            <div class="product-overlay">
                                <a class="btn btn-lg-square btn-outline-light rounded-circle" href=""><i class="fa fa-eye text-primary"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!--prodCard wrkg -->$_COOKIE<div class="card mb-4 product border-1 pb-3">
    <?php if ($model->cover_image_id) { ?>
        <img src="<?= Yii::$app->storage->getImage($model->cover_image_id)->source; ?>" alt="<?= $model->name ?>" title="<?= $model->name ?>" class="card-img-top">
    <?php } else { ?>
        <img class="card-img-top" src="<?= Yii::$app->params['image']['none'] ?>" alt="">
    <?php } ?>
    <span class="badge bg-success position-absolute text-white mt-2 ms-2"><a href="/" class="text-white"><?= $model->groups[0]->name; ?></a></span>
    <!--
    <php if($model->statuses):?>
    <span class="badge  text-white position-absolute r-0 mt-2 me-2" style="background-color:<=$model->statuses[0]->color;?>;">       
         <= $model->statuses[0]->name; ?>    
    </span>
    <php endif; ?>
    -->
    <span class="rounded position-absolute p-2 bg-warning text-white ms-2 small mt-5"></span>
    <div class="card-body overflow-hidden position-relative p-0">
        <h6 class="card-subtitle mb-2"><a class="text-decoration-none" href="/product/detail"><?= $model->name; ?></a></h6>
        <div class="my-2"><span class="fw-bold h5"><?php echo $model->articles[0]->price; ?></span>
            <!--<del class="small text-muted ms-2">$2000</del>  -->
            <span class="ms-2">
                <!--php
                $floor = floor($rating['value']);
                for ($i = 0; $i < $floor; $i++) {
                    echo '<span><i class="fa fa-star text-warning"></i></span> ';
                    }
                if ($floor < $rating['value']) {
                        echo '<span><i class="fa fa-star-half text-warning"></i></span> ';
                }
                ?-->
            </span>
        </div>
        <div class="btn-group  d-flex" role="group">
            <button type="button" class="btn btn-sm btn-primary" title="Add to cart">
                <img src="/image/site/cart.svg">
            </button>
            <a type="button" href="<?= $link; ?>" class="btn btn-sm btn-outline-warning" title="View Detail">
                <img src="/image/site/eye.svg">
            </a>
        </div>
    </div>
</div>