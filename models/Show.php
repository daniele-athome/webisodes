<?php

namespace app\models;

use yii;

/**
 * This is the model class for table "shows".
 *
 * The followings are the available columns in table 'shows':
 * @property integer $_id
 * @property integer $tvdb_id
 * @property string $name
 * @property string $overview
 * @property string $first_aired
 * @property boolean $starred
 * @property string $banner_path
 * @property string $fanart_path
 * @property string $poster_path
 * @property string $notes
 * @property int watchedCount
 * @property int airedCount
 * @property int episodesCount
 * @property int seasonsCount
 */
class Show extends yii\db\ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'shows';
	}

	public function getEpisodes()
    {
        return $this->hasMany(Episode::className(), ['show_id' => '_id'])
            ->orderBy('season_number,episode_number');
    }

    /**
     * Seasons count (specials are season zero)
     * @return int
     */
    public function getSeasonsCount()
    {
        return $this->getEpisodes()
            ->max('season_number');
    }

    /**
     * Total episodes count (without specials)
     * @return int
     */
    public function getEpisodesCount()
    {
        return $this->getEpisodes()
            ->andWhere('season_number > 0')
            ->count();
    }

    /**
     * Watched count (without specials)
     * @return int
     */
    public function getWatchedCount()
    {
        return $this->getEpisodes()
            ->andWhere('watched <> 0 and season_number > 0')
            ->count();
    }

    /**
     * Aired count (without specials)
     * @return int
     */
    public function getAiredCount()
    {
        return $this->getEpisodes()
            ->andWhere('season_number > 0 and first_aired is not null and first_aired < strftime(\'%s\', \'now\')')
            ->count();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'_id' => 'ID',
			'tvdb_id' => 'Tvdb',
			'name' => 'Name',
			'overview' => 'Overview',
			'first_aired' => 'First Aired',
			'starred' => 'Starred',
			'banner_path' => 'Banner Path',
			'fanart_path' => 'Fanart Path',
			'poster_path' => 'Poster Path',
			'notes' => 'Notes',
		);
	}

    function getBannerURL() {
        return Yii::$app->params['tvdb_cache'] . '/' . $this->banner_path;
    }

    function getFanartURL() {
        return Yii::$app->params['tvdb_cache'] . '/' . $this->fanart_path;
    }

    function getSeasonsStat() {
        return Episode::getSeasonsStat($this->_id);
    }

    public function season($season) {
	    return new yii\data\ActiveDataProvider([
	        'query' => Episode::find()
                ->andFilterWhere(['show_id' => $this->_id, 'season_number' => $season]),
            'pagination' => false,
        ]);
    }
}
