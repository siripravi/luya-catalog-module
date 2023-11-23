<?php

/**
 * View file for block: BannerBlock 
 *
 * File has been created with `block/create` command on LUYA version 1.0.0-RC3. 
 *
 * @param $this->varValue('subTitle');
 * @param $this->varValue('title');
 *
 * @var \luya\cms\base\PhpBlockView $this
 * @var \luya\web\LinkInterface $link
 */

use yii\helpers\Html;
use yii\helpers\Url;
use luya\lazyload\LazyLoad;

$image = $this->extraValue('image');
$title = $this->varValue('title');
$subTitle = $this->varValue('subTitle');
$text = $this->varValue('text');
$link = $this->extraValue('link');
$buttonName = $this->varValue('buttonName');

$titleHeading = $this->cfgValue('title-heading', 'h2');
?>
<?php echo Html::beginTag('div', [
  'class' => 'hero',
  'style' => ['background' => 'url(' . str_replace("\\", "/", $image->source) . ')', "background-size" => "cover;"],
]) ?>
<div class="container">
  <div class="row">
    <div class="col-md-12 ">
      <div class="wrapper" style="height: 625px;">
        <div class="inner" style="top: 209px;">
          <?php if ($image) : ?>
            <!--<div class="image object">
                                <php echo Html::img($image->source, [
                                    'width' => $image->resolutionWidth,
                                    'height' => $image->resolutionHeight
                                ]) >
                            </div> -->
          <?php endif ?>
          <?php if ($title) : ?>
            <?php echo Html::tag($titleHeading, Html::encode($title), ['class' => 'title']) ?>
          <?php endif ?>
          <?php if ($subTitle) : ?>
            <?php echo Html::tag('p', Html::encode($subTitle), ['class' => 'style1']) ?>
          <?php endif ?>
          <?php if ($text) : ?>
            <?php echo Html::tag('p', $text, ['class' => 'style3']) ?>
          <?php endif ?>

          <?php if ($link) : ?>
            <ul class="actions">
              <li><?php echo Html::a($buttonName ?: $link->getHref(), $link->getHref(), ['target' => $link->getTarget(), 'class' => 'button style3 large']) ?></li>
            </ul>
          <?php endif ?>
          <!-- <img class="title img-responsive hidden-xs" src="/image/site/title.png" alt="" width="823" height="170"> -->
          <p class="subheader">Since 1991, we have strived to provide fresh and high quality baked goods for the Southern California area. So please enjoy – this is our heritage.</p>

        </div>
      </div>

      <div class="go-down">
        <img src="/image/site/bell.png" alt="" width="53" height="59" class="hidden-xs">
        <p>come on down, buddy!</p>
        <a href="#" data-scrollto="types" class="down-btn"><img src="/image/site/img/down.png" alt="" width="13px" height="8px"></a>
      </div>

    </div>
  </div>
</div>
</div>
<img src="/image/site/img/border-effect.png" alt="" class="border-effect bottom">