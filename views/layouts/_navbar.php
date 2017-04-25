<?php
use yii\bootstrap\Nav;
use yii\helpers\Html;

?>

<div class="masthead clearfix">
    <div class="inner">
        <h3 class="masthead-brand"><?=
            Html::img(Yii::$app->urlManager->baseUrl.'/img/logo.png', ['alt' => 'Logo','class' => 'logo']) .Yii::$app->name; ?></h3>

        <?= Nav::widget([
                'options' => ['class' => 'nav masthead-nav'],
                'encodeLabels' => false,
                'dropDownCaret' => '',
                'items' => [
                    ['label'=>'Home', 'url'=> ['/dashboard/index']],
                    ['label'=>'Shows', 'url'=> ['/show/index']],
                    ['label'=>'<span class="glyphicon glyphicon-menu-hamburger"></span>', 'url'=>'#', 'items' => [
                        ['label' => 'All shows', 'url' => ['/show/index']],
                        ['label' => 'Starred shows', 'url' => ['/show/starred']],
                        ['label' => 'Uncompleted shows', 'url' => ['/show/uncompleted']],
                    ]],
                    ['label'=>'<span class="glyphicon glyphicon-search"></span>', 'url'=>'#'],
                ]]
        ); ?>
    </div>
</div>
