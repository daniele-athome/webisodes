<?php

namespace app\components;

use app\helpers\Helpers;
use app\models\Bill;
use app\models\BillSearch;
use app\models\DocProperty;
use app\models\Payment;
use app\models\Utility;
use app\widgets\grid\FundlogPropertyHandler;
use Cron\CronExpression;
use yii;
use yii\bootstrap\Html;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends yii\web\Controller
{
    public function init()
    {
        $this->getView()->on(yii\web\View::EVENT_BEGIN_PAGE, [$this, 'beginPage']);
    }

    /** @param $event yii\base\ViewEvent */
    protected function beginPage($event)
    {
        $this->getView()->title .= ' - ' . Yii::$app->name;
    }

}
