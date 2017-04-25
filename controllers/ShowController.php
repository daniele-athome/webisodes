<?php

namespace app\controllers;

use app\components\BaseController;
use app\models\Show;
use yii;

class ShowController extends BaseController
{
	public function actionView($id)
	{
		return $this->render('view', [
			'model'=>$this->loadModel($id),
        ]);
	}

	public function actionIndex()
	{
		$query = Show::find()
            ->orderBy(['starred' => SORT_DESC, 'name' => SORT_ASC]);
		return $this->render('index', [
			'dataProvider' => new yii\data\ActiveDataProvider(['query' => $query, 'pagination' => false]),
        ]);
	}

	public function loadModel($id)
	{
		$model=Show::findOne($id);
		if($model===null)
			throw new yii\web\HttpException(404,'The requested page does not exist.');
		return $model;
	}
}
