<?php

use yii\helpers\Url;
use yii\helpers\Html;

$model = $this->extraValue('summary');
$fsel = ($model->formatFText($model->FeatureText)) ?: [];
/*
echo "<pre>";
print_r($fsel);
echo "</pre>";  die;
*/
?>
  
  
    <?php if(!empty($fsel) && count($fsel[0]) == 3) : ?>
    <h5 class="card-title">Your Selections:</h5>
    <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
    <div class="mb-3">
      <!--<div class="d-grid gap-4 d-md-flex ">  -->
      <div id="feat-sel" class="d-flex text-inline" role="radiogroup">
        <?php
        foreach ($fsel as $fs) :  ?>
          <div class="p-2 flex-fill position-relative" id="Feat-<?= $fs[1]; ?>">
            <input type="radio" class="btn-check" checked="checked">
            <label class="btn btn-outline-primary" for="Feat-<?= $fs[1]; ?>">
              <i class="bi bi-circle pe-2" style="font-size:20px;"></i>
              <span class="text-light"><?= $fs[0]; ?>
              </span>
            </label>
            <span class="position-absolute top-2 start-10 translate-middle badge rounded-pill bg-danger">
              <span class="pe-2">₹</span><?= $fs[2]; ?><span class="visually-hidden"></span>
            </span>
          </div>
          <!--
        <button type="button" class="btn btn-primary position-relative">
            <i class="bi bi-check pe-2" style="font-size:20px;"></i><= $fs[0]; ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              <span class="pe-2">₹</span><= $fs[2]; ?>
              <span class="visually-hidden"></span>
            </span>
          </button>
        -->
        <?php endforeach;  ?>
      </div>
    </div>
    <?php endif;  ?>
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->


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