<?php
/* @var $this yii\web\View */
/* @var $upcoming array */
/* @var $uncompleted array */

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
        <?= $this->render('_carousel', array('data' => $upcoming)); ?>
    </div>

    <div class="col-md-6">
        <?= \yii\widgets\ListView::widget([
            'dataProvider'=>$uncompleted,
            'summary'=>'',
            'itemView'=>'/show/_view',
        ]) ?>
    </div>

</div>

