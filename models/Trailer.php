<?php

namespace app\models;

use yii;

/**
 * This is the model class for table "trailers".
 *
 * The followings are the available columns in table 'trailer':
 * @property integer $episode_id thetvdb.com actual episode id
 * @property string $youtube_id
 * @property integer last_check
 */
class Trailer extends yii\db\ActiveRecord
{
    // 7 days
    const MAX_CHECK_TIME = 604800;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'support.trailers';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'episode_id' => 'Episode',
            'youtube_id' => 'Youtube',
            'last_check' => 'Last Check',
        );
    }

    public function needsRefresh()
    {
        return (time() - $this->last_check) > self::MAX_CHECK_TIME;
    }
}
