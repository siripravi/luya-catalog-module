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
    $data = Yii::$app->forms->getFormData();
    if(!empty($data)){
    $id = implode("+", $data['Features']);
    $price = $data['Price'];
    } 
?>
<?php if (Yii::$app->session->getFlash('formDataSuccess')) : ?>
    <?= $this->placeholderValue('success'); ?>
<?php else : ?>
    <?php if ($this->extraValue('isPreview')) : ?>
        <?= $this->placeholderValue('preview'); ?>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <?= StringHelper::template($this->varValue('previewButtonsTemplate', $this->context->previewButtonsTemplate), [
                //'back' => Html::a($this->cfgValue('previewBackButtonLabel', Yii::t('forms', 'Back')), '&reload=' . $this->varValue('formId'), Yii::$app->forms->backButtonOptions),
                'submit' => Html::a('Confirm & Submit', Yii::$app->request->referrer . '&submit=' . $this->varValue('formId'), ['id'=>'btn-buy','data-formid'=>$this->varValue('formId'),'data-key' =>$id,'data-price'=>$price,'class' => 'btn btn-success btn-buy']),
                //Html::a($this->cfgValue('previewSubmitButtonLabel', Yii::t('forms', 'Submit')), '?submit=' . $this->varValue('formId'), Yii::$app->forms->submitButtonsOptions),
                ]); 
            ?>
        </div>
    <?php else : ?>
        <?php if (Yii::$app->forms->model->hasErrors()) : ?>
            <?= Yii::$app->forms->form->errorSummary(Yii::$app->forms->model); ?>
        <?php endif; ?>
        <?= $this->placeholderValue('content'); ?>
        <!--= Html::submitButton($this->cfgValue('submitButtonLabel', Yii::t('forms', 'Submit')), Yii::$app->forms->submitButtonsOptions); ?-->
        <div class="form-group mt-3">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit"  class="btn btn-success me-md-2">
                    Order Now
                </button>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
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

