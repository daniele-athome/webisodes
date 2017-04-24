<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#3c76e7"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="shortcut icon" href="<?php echo Yii::$app->urlManager->baseUrl; ?>/favicon.ico" type="image/x-icon" />
    <link rel="icon" sizes="256x256" href="<?php echo Yii::$app->urlManager->baseUrl; ?>/img/logo_hi.png">
    <link rel="apple-touch-icon" sizes="256x256" href="<?php echo Yii::$app->urlManager->baseUrl; ?>/img/logo_hi.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="site-wrapper" id="page">

    <div class="container">
        <div class="row">

            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand"><?=
                        Html::img(Yii::$app->urlManager->baseUrl.'/img/logo.png', ['alt' => 'Logo','class' => 'logo']) .Yii::$app->name; ?></h3>

                    <?= Nav::widget([
                        'options' => ['class' => 'nav masthead-nav'],
                        'encodeLabels' => false,
                        'items' => [
                            ['label'=>'Home', 'url'=> ['/dashboard/index']],
                            ['label'=>'Shows', 'url'=> ['/show/index']],
                            ['label'=>'<span class="glyphicon glyphicon-search"></span>', 'url'=>'#'],
                        ]]
                    ); ?>
                </div>
            </div>

            <div class="inner cover">
                <?= $content; ?>
            </div>

            <footer class="mastfoot">
                <div class="inner">
                    <p>
                        Copyright &copy; <?= date('Y'); ?> <?= Yii::$app->params['author']; ?><br/>
                        <?= Yii::powered(); ?>
                    </p>
                </div>
            </footer>

        </div>
    </div>

</div><!-- page -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
