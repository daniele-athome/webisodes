<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

/* @var $model \app\models\Show */

$this->title = $model->name;

$seasons_stat = $model->getSeasonsStat();
$num_seasons = $model->seasonsCount;
?>

<div class="row">
    <div class="series-view col-md-12">

        <img class="series-banner" src="<?php echo $model->getFanartURL(); ?>"/>

        <h1 class="cover-heading">
        <?php echo $model->name; ?>
        </h1>

        <p class="lead">
        <?php echo $model->overview; ?>
        </p>

    </div>
</div>

<?php
foreach ($seasons_stat as $season):
    $no = $season['season_number'];
    $watched = $season['watched'];
    $aired = $season['aired'];
    $upcoming = $season['total']-$aired;
    $percent = $aired > 0 ? round($watched * 100 / $aired) : 0;

    if ($no > 0)
        $title = Yii::t('default', 'Season {season}', array('season' => $no));
    else
        $title = Yii::t('default', 'Specials');

?>
<div class="row">
    <div class="season-item col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo Html::a($title,
                        ['episode/season', 'show' => $model->_id, 'season' => $no]); ?></h3>
            </div>
            <div class="panel-body">

                <div class="series-progress">
                    <div class="series-progress-label">
                        <?php echo Yii::t('default', 'Watched {watched} of {total} episodes',
                            ['watched' => $watched, 'total' => $aired]); ?>
                        <?php if ($upcoming > 0): ?>
                            <?php echo Yii::t('default', ' (+{upcoming} upcoming)',
                                ['upcoming' => $upcoming]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="series-progress-bar" role="progressbar" style="width: <?php echo $percent; ?>%"></div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php
endforeach;
?>
