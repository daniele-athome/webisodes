<?php
/* @var $this yii\web\View */
/* @var $data array */

$count = count($data);
if (!$count):
?>

<h3>No trailers available.</h3>

<?php
else:
?>

<div id="carousel-videos" class="carousel slide" data-ride="carousel" data-interval="">

    <!--
    <ol class="carousel-indicators">
        <?php for ($i = 0; $i < $count; $i++): ?>
            <li data-target="#carousel-videos" data-slide-to="<?= $i; ?>"<?php if ($i == 0): ?> class="active"<?php endif; ?>></li>
        <?php endfor; ?>
    </ol>
    -->

    <div class="carousel-inner" role="listbox">
        <?php $i = 0; foreach ($data as $ep):
            ?>
            <div class="item<?php if ($i == 0): ?> active<?php endif; ?>">

                <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?= $ep->trailer->youtube_id; ?>" frameborder="0" allowfullscreen></iframe>

            </div>
        <?php
            $i++;
            endforeach;
        ?>
    </div>

    <a class="left carousel-control" href="#carousel-videos" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-videos" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

</div>

<?php
endif;
