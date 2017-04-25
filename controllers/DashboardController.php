<?php

namespace app\controllers;

use app\helpers\Helpers;
use app\models\Bill;
use app\models\BillSearch;
use app\models\Budget;
use app\models\Episode;
use app\models\LoanIn;
use app\models\Payment;
use app\models\Show;
use yii;
use app;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * Home page controller.
 */
class DashboardController extends app\components\BaseController
{
    const MAX_HOME_RESULTS = 10;

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // retrieve the earliest 10 episodes from 10 different starred shows yet to be watched
        $data = Episode::find()
            ->alias('t')
            ->with('trailer')
            ->joinWith('show')
            ->andWhere('t.first_aired is not null')
            ->andWhere('shows.starred <> 0')
            ->andWhere('(t.watched = 0 or t.watched is null)')
            ->andWhere('t.season_number > 0')
            ->orderBy('t.first_aired')
            ->all();

        // extract only 10 episodes from 10 distinct shows
        $show_id = null;
        $result = array();
        foreach ($data as $ep) {
            /** @var $ep Episode */
            if (!isset($result[$ep->show_id])) {
                if (!$ep->trailer or $ep->trailer->needsRefresh()) {
                    //var_dump("Episode ". $ep->name . "Needs refresh");
                    if ($this->lookupTrailer($ep)) {
                        // FIXME reload relation
                        $ep->getTrailer();
                        //$ep->getRelated('trailer', true);
                    }
                }

                if ($ep->trailer and $ep->trailer->youtube_id) {
                    $result[$ep->show_id] = $ep;
                    if (count($result) >= self::MAX_HOME_RESULTS)
                        break;
                }
            }
        }

        // retrieve uncompleted shows
        $data = Episode::find()
            ->alias('t')
            ->with('trailer')
            ->joinWith('show')
            ->andWhere('t.first_aired is not null')
            ->andWhere('shows.starred <> 0')
            ->andWhere('(t.watched = 0 or t.watched is null)')
            ->andWhere('t.season_number > 0')
            ->orderBy('shows.name')
            ->all();

        $uncompleted = [];
        $show_id = null;
        foreach ($data as $ep) {
            if ($ep->show_id != $show_id) {
                /** @var $show Show */
                $show = $ep->show;
                if (($show->airedCount - $show->watchedCount) > 0)
                    $uncompleted[] = $show;
                $show_id = $ep->show_id;
            }
        }

        return $this->render('index', [
            'upcoming'=>$result,
            'uncompleted'=>new ArrayDataProvider([
                'allModels' => $uncompleted,
                'key' => '_id',
                'pagination' => false
            ]),
        ]);
    }

    /**
     * @var $ep Episode
     * @return bool
     */
    private function lookupTrailer($ep)
    {
        if ($ep->name) {
            $result = Yii::$app->youtube->searchVideo($ep->getTrailerQuery(), 5);
            if ($result) {
                foreach ($result as $video) {
                    // we need both show title and episode title
                    if (stristr($video['title'], $ep->name) and stristr($video['title'], $ep->show->name)) {
                        $tr = $ep->trailer ? $ep->trailer : new app\models\Trailer();
                        $tr->episode_id = $ep->tvdb_id;
                        $tr->youtube_id = $video['id'];
                        $tr->last_check = time();
                        $tr->save();
                        return true;
                    }
                }
            }
        }

        // create dummy record
        if ($ep->trailer) {
            $ep->trailer->last_check = time();
            $ep->trailer->save();
        }
        else {
            $tr = new app\models\Trailer();
            $tr->episode_id = $ep->tvdb_id;
            $tr->last_check = time();
            $tr->save();
        }
        return false;
    }

}
