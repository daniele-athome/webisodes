<?php

namespace app\controllers;

use app\helpers\Helpers;
use app\models\Bill;
use app\models\BillSearch;
use app\models\Budget;
use app\models\Episode;
use app\models\LoanIn;
use app\models\Payment;
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
                        $ep->getRelated('trailer', true);
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
            ->orderBy('show.name')
            ->all();

        $uncompleted = [];
        $show_id = null;
        foreach ($data as $ep) {
            if ($ep->show_id != $show_id) {
                /** @var $show Show */
                $show = $ep->show;
                if (($show->aired_count - $show->watched_count) > 0)
                    $uncompleted[] = $show;
                $show_id = $ep->show_id;
            }
        }

        $this->render('index', [
            'upcoming'=>$result,
            'uncompleted'=>new ArrayDataProvider($uncompleted, ['key'=>'_id']),
        ]);
    }

}
