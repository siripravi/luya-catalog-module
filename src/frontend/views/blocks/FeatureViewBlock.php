<?php

/**
 * View file for block: FormBlock *
 * File has been created with `block/create` command. *
 * @param $this->placeholderValue('content');
 * @param $this->varValue('formId'); *
 * @var \luya\cms\base\PhpBlockView $this
 */

use luya\helpers\Html;
use luya\helpers\StringHelper;
?>
<?php

//$data = Yii::$app->forms->getFormData();
$model = $this->extraValue('summary');
$fsel = ($model->formatFText($model->FeatureText)) ?: [];
$price = end($fsel)['price'];
//echo "<pre>"; print_r($data); echo "</pre>";
/*if (!empty($data)) {  
} else {
    $data['Price'] = 0;
    $data['Features'] = [];
    $data['FeatureText'] = "";
}*/
?>
<?php if (Yii::$app->session->getFlash('formDataSuccess')) : ?>
    <?= $this->placeholderValue('success'); ?>
<?php else : ?>
    <div class="card border-success mb-4">
        <div class="card-header bg-info">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="w-75 p-3"><span style="vertical-align:super;font-size:31px; padding-right:5px;" class="moneySymbol">₹</span>
                        <span class="" data-inr="<?= $price; ?>" style="color: #fff; font-size: 48px; font-weight: 600;" id="xproductPrice"><?= $price; ?></span>
                    </h3>
                </div>
                <div class="col-md-2 float-right">                   
                        <?= Html::a('Edit',  Yii::$app->request->referrer, ['class' => 'nav-link']); ?>                   
                </div>
            </div>
            <?php if (!empty($fsel) && count($fsel[0]) == 4) : ?>
                <h5 class="card-title">Your Selections:</h5>               
                <div class="mb-3">                   
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
                        <?php endforeach;  ?>
                    </div>
                </div>
            <?php endif;  ?>
        </div>
        <div class="card border-primary">         
                <?php if (Yii::$app->forms->model->hasErrors()) : ?>
                    <?= Yii::$app->forms->form->errorSummary(Yii::$app->forms->model); ?>
                <?php endif; ?>
                <?= $this->placeholderValue('content'); ?>             
         
        </div>
    </div>
<?php endif; ?>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">  
        <?= Html::a('Confirm & Submit', Yii::$app->request->referrer . '&submit=' . $this->varValue('formId'), ['id' => 'btn-buy', 'data-formid' => $this->varValue('formId'),  'class' => 'btn btn-success btn-buy']);
        ?>
    
</div>
<?php if(Yii::$app->forms->model->isPjax) : ?>
<?php yii\widgets\Pjax::end(); ?> <!-- end of pjax-->
<?php Yii::$app->forms->form->end(); ?>

<?php endif; ?>

<div class="modal" tabindex="-1" id="exampleModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>