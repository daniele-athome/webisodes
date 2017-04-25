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

    public function actionStarred()
    {
        $query = Show::find()
            ->andWhere('starred <> 0')
            ->orderBy('name');
        return $this->render('index', [
            'dataProvider' => new yii\data\ActiveDataProvider(['query' => $query, 'pagination' => false]),
        ]);
    }

    public function actionUncompleted()
    {
        $data = Show::find()
            ->joinWith('episodes')
            ->orderBy(['starred' => SORT_DESC, 'name' => SORT_ASC])
            ->all();
        $filtered = [];
        foreach ($data as $show) {
            /** @var $show Show */
            if ($show->watchedCount < $show->episodesCount) {
                $filtered[] = $show;
            }
        }

        return $this->render('index', [
            'dataProvider' => new yii\data\ArrayDataProvider(['allModels' => $filtered, 'pagination' => false]),
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
