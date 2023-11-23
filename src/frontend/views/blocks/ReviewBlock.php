<!-- Testimonial Start -->
<div class="row">
    <div class="col-md-8">
        <?= $this->placeholderValue('left'); ?>
        <?php foreach ($this->extraValue('foobar') as $model) {
            echo $model->name;
            echo " ";
            // assuming the title is an attribute of the Article model defined in the query part of the injector.
        } ?>
    </div>
    <div class="col-md-4">
        <?= $this->placeholderValue('right'); ?>
    </div>
</div>