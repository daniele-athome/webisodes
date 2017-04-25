<?php

namespace app\models;

use yii;

/**
 * This is the model class for table "episodes".
 *
 * The followings are the available columns in table 'episodes':
 * @property integer $_id
 * @property integer $tvdb_id
 * @property integer $show_id
 * @property string $name
 * @property string $overview
 * @property integer $episode_number
 * @property integer $season_number
 * @property string $first_aired
 * @property boolean $watched
 * @property Show show
 * @property Trailer trailer
 */
class Episode extends yii\db\ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'episodes';
    }

    public function getShow() {
        return $this->hasOne(Show::className(), ['_id' => 'show_id']);
    }

    public function getTrailer() {
        return $this->hasOne(Trailer::className(), ['episode_id' => 'tvdb_id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'tvdb_id' => 'Tvdb',
            'show_id' => 'Show',
            'name' => 'Name',
            'overview' => 'Overview',
            'episode_number' => 'Episode Number',
            'season_number' => 'Season Number',
            'first_aired' => 'First Aired',
            'watched' => 'Watched',
        ];
    }

    public function getScreenshotURL() {
        return sprintf('%s/episodes/%s/%s.jpg', Yii::$app->params['tvdb_cache'], $this->show->tvdb_id, $this->tvdb_id);
    }

    public static function getSeasonsStat($show_id) {
        return static::find()
            ->select(array(
                    'season_number',
                    'count(case watched when 0 then null else watched end) watched',
                    'count(case when (first_aired is not null and first_aired < strftime(\'%s\', \'now\')) then 1 else null end) aired',
                    'count(*) total')
            )
            ->from(self::tableName())
            ->where('show_id=:show', array(':show' => $show_id))
            ->groupBy('season_number')
            ->all();
    }

    function getTrailerQuery() {
        return sprintf('%s %s trailer', $this->show->name, $this->name);
    }

    public function season($season) {
        return new yii\data\ActiveDataProvider([
            'query' => Episode::find()->andFilterWhere(['show_id' => $this->show_id, 'season_number' => $season]),
            'pagination' => false,
        ]);
    }

}
