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
 * @property int watched_count
 * @property int aired_count
 * @property int episodes_count
 * @property int seasons_count
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

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
	    // FIXME
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'episodes' => array(self::HAS_MANY, 'Episode', 'show_id', 'order'=>'season_number,episode_number'),
            // watched count (without specials)
			'watched_count' => array(self::STAT, 'Episode', 'show_id', 'condition' => 'watched<>0 and season_number > 0'),
            // aired count (without specials)
            'aired_count' => array(self::STAT, 'Episode', 'show_id', 'condition' => 'season_number > 0 and first_aired is not null and first_aired < strftime(\'%s\', \'now\')'),
            // total episodes count (without specials)
            'episodes_count' => array(self::STAT, 'Episode', 'show_id', 'condition' => 'season_number > 0'),
            // seasons count (specials are season zero)
            'seasons_count' => array(self::STAT, 'Episode', 'show_id', 'select' => 'max(season_number)'),
		);
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
	    // FIXME
        $criteria=new CDbCriteria;
        $criteria->compare('show_id', $this->_id);
        $criteria->compare('season_number', $season);

        return new CActiveDataProvider(Episode::model(), array(
            'criteria'=>$criteria,
        ));
    }
}
