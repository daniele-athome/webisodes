<?php
/* @var $this yii\web\View */
/* @var $upcoming array */

$this->title = 'Home';
?>

<style type="text/css">
    @media (min-width: 992px) {
        .masthead,
        .mastfoot,
        .container {
            width: 960px;
        }
    }
</style>

<div class="row">

    <div class="col-md-6">
        <?php $this->render('_carousel', array('data' => $upcoming)); ?>
    </div>

    <div class="col-md-6">
        <?php /*$this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$uncompleted,
            'summaryText'=>'',
            'summaryCssClass'=>'hide',
            'itemView'=>'application.views.show._view',
            'enablePagination'=>false,
        ));*/ ?>
    </div>

</div>

