<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Episode;
use app\models\Show;
use yii;

class EpisodeController extends BaseController
{
	public function actionView($id)
	{
        return $this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionSeason($show, $season) {
        return $this->render('season',array(
            'show' => Show::findOne($show),
            'season' => $season,
            'models'=>Episode::findAll(['show_id' => $show, 'season_number' => $season]),
        ));
    }

	public function loadModel($id)
	{
		$model=Episode::findOne($id);
		if($model===null)
			throw new yii\web\HttpException(404,'The requested page does not exist.');
		return $model;
	}
}
