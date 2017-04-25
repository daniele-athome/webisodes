<?php
/* @var $this yii\web\View */
/* @var $model \app\models\Episode */

if ($model->season_number > 0)
    $title = Yii::t('default', 'Season {season}', array('season' => $model->season_number));
else
    $title = Yii::t('default', 'Specials');

$this->title=sprintf('%s - %s', $model->name, $model->show->name);
?>

<div class="row">
    <div class="episode-view col-md-12">

        <h1 class="cover-heading series-title">
            <?php echo $model->show->name; ?><br/>
            <small><?php echo $title; ?></small>
        </h1>

        <img class="episode-banner" alt="Screenshot" src="<?php echo $model->getScreenshotURL(); ?>"/>

        <h1 class="cover-heading">
        <?php echo sprintf('%d - %s', $model->episode_number, $model->name); ?><br/>
        <small>
            <?php echo Yii::$app->formatter->asDate($model->first_aired, 'full'); ?>
            <span class="hidden-xs">&mdash;</span>
            <br class="visible-xs"/>
            <?php echo Yii::t('default', $model->watched ? 'Watched' : 'Not watched'); ?>
        </small>
        </h1>

        <p class="lead">
        <?php echo $model->overview; ?>
        </p>

    </div>
</div>
