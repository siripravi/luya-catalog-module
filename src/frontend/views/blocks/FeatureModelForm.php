<?php

/**
 * View file for block: FormBlock
 *
 * File has been created with `block/create` command.
 *
 * @param $this->placeholderValue('content');
 * @param $this->varValue('formId');
 *
 * @var \luya\cms\base\PhpBlockView $this
 */

use luya\helpers\Html;
use luya\helpers\StringHelper;
?>
<?php
$isPreview = $this->extraValue('isPreview');
$priceClass = ($isPreview == 1) ? "" : "moneyCal ";
$data = Yii::$app->forms->getFormData();

//print_r($data);
//$data['Price'] = 0;$data['Features'] = [];
if (!empty($data)) {
    $id = implode("+", $data['Features']);
    $price = $data['Price'];
}
else{
    $data['Price'] = 0;
    $data['Features'] = [];
}
?>

<?php if (Yii::$app->session->getFlash('formDataSuccess')) : ?>
    <?= $this->placeholderValue('success'); ?>
<?php else : ?>
    <div class="card border-success mb-4">
        <div class="card-header bg-info">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="w-75 p-3"><span style="vertical-align:super;font-size:31px; padding-right:5px;" class="moneySymbol">₹</span>
                        <span class="<?= $priceClass; ?> " data-inr="<?= $data['Price']; ?>" style="color: #fff; font-size: 48px; font-weight: 600;" id="xproductPrice"><?= $data['Price']; ?></span>
                    </h3>
                </div>
                <div class="col-md-2 float-right">
                    <?php if ($isPreview == 1) : ?>
                        <?= Html::a('Edit',  Yii::$app->request->referrer, ['class' => 'nav-link']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card border-primary">
            <?php if ($isPreview) : ?>
                <?= $this->placeholderValue('preview'); ?>
            <?php else : ?>
                <?php if (Yii::$app->forms->model->hasErrors()) : ?>
                    <?= Yii::$app->forms->form->errorSummary(Yii::$app->forms->model); ?>
                <?php endif; ?>
                <?= $this->placeholderValue('content'); ?>
                <!--= Html::submitButton($this->cfgValue('submitButtonLabel', Yii::t('forms', 'Submit')), Yii::$app->forms->submitButtonsOptions); ?-->
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <?php if ($isPreview) : ?>
        <?= StringHelper::template($this->varValue('previewButtonsTemplate', $this->context->previewButtonsTemplate), [
            //'back' => Html::a($this->cfgValue('previewBackButtonLabel', Yii::t('forms', 'Back')), '&reload=' . $this->varValue('formId'), Yii::$app->forms->backButtonOptions),
            'submit' => Html::a('Confirm & Submit', Yii::$app->request->referrer . '&submit=' . $this->varValue('formId'), ['id' => 'btn-buy', 'data-formid' => $this->varValue('formId'), 'data-key' => $id, 'data-price' => $price, 'class' => 'btn btn-success btn-buy']),
            //Html::a($this->cfgValue('previewSubmitButtonLabel', Yii::t('forms', 'Submit')), '?submit=' . $this->varValue('formId'), Yii::$app->forms->submitButtonsOptions),
        ]);
        ?>
    <?php else : ?>
        <button type="submit" class="btn btn-success me-md-2">
            Order Now
        </button>
    <?php endif; ?>
</div>
<?php Yii::$app->forms->form->end(); ?>
<?php if (empty($this->varValue('formId'))) : ?>
    <div style="background-color:red; color:white; padding:20px;"><?= Yii::t('forms', 'This form block is not properly configured. Select a form from the listing in the block settings.'); ?></div>
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