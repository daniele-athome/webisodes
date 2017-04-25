<?php
/* @var $this yii\web\View */
/* @var $model \app\models\Show */

$upcoming = $model->episodesCount - $model->airedCount;
$percent = $model->airedCount > 0 ? round($model->watchedCount * 100 / $model->airedCount) : 0;
?>

<div class="row">
<div class="series-item col-md-12">

    <?php echo \yii\helpers\Html::a(\yii\helpers\Html::img($model->getBannerURL(), ['alt' => $model->name]),
        ['show/view', 'id'=>$model->_id], array('title' => $model->name)); ?>

    <div class="series-progress">
        <div class="series-progress-label">
            <?= Yii::t('default', 'Watched {watched} of {total} episodes',
                ['watched' => $model->watchedCount, 'total' => $model->airedCount]); ?>
            <?php if ($upcoming > 0): ?>
                <?= Yii::t('default', ' (+{upcoming} upcoming)',
                    ['upcoming' => $upcoming]); ?>
            <?php endif; ?>
        </div>
        <div class="series-progress-bar" role="progressbar" style="width: <?php echo $percent; ?>%"></div>
    </div>

</div>
</div>
