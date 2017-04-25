<?php
/* @var $this yii\web\View */
/* @var $show \app\models\Show */
/* @var $season int */
/* @var $models array(Episode) */

if ($season > 0)
    $title = Yii::t('default', 'Season {season}', array('season' => $season));
else
    $title = Yii::t('default', 'Specials');

$this->title=sprintf('%s - %s', $title, $show->name);
?>

<div class="row">
    <div class="col-md-12">

        <h1 class="cover-heading">
            <?php echo $show->name; ?><br/>
            <small><?php echo $title; ?></small>
        </h1>

    </div>
</div>

<?php
foreach ($models as $model):
    /* @var $model \app\models\Episode */
    $aired = (($model->first_aired != null) and (intval($model->first_aired) < time()));
?>
    <div class="row">
        <div class="episode-item col-md-12">
            <div class="panel<?php echo (!$aired) ? " panel-disabled" : ""; ?>">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo \yii\helpers\Html::a(sprintf('%d - %s', $model->episode_number, $model->name),
                            ['episode/view', 'id' => $model->_id]); ?></h3>
                    <?php if ($model->watched): ?>
                    <h2 class="pull-right glyphicon glyphicon-ok"></h2>
                    <?php endif; ?>
                </div>
                <div class="panel-body">
                    <?php echo Yii::$app->formatter->asDate($model->first_aired, 'full'); ?>
                </div>

            </div>
        </div>
    </div>
    <?php
endforeach;
?>
