<?php
use siripravi\catalog\frontend\widgets\Carousel;

$imageInfo = $this->extraValue('articleImages');

echo Carousel::widget([
    'items' =>
    $imageInfo['images'],
    'thumbnails'  => $imageInfo['thumbnails'],
    'options' => [
        'data-interval' => 3, 'data-bs-ride' => 'scroll', 'class' => 'carousel product_img_slide',
    ],
    //'options'  => ['class' => 'carousel product_img_slide','ride'=>true]

]);