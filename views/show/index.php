<?php
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('default', 'Shows');
?>

<?= \yii\widgets\ListView::widget([
    'dataProvider'=>$dataProvider,
    'summary'=>'',
    'itemView'=>'_view',
]);
?>
