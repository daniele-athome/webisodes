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

    public static function setup()
    {
        // FIXME this won't work because schema name is not supported by Yii2 SQLite module
        try {
            static::getTableSchema();
        }
        catch (yii\base\InvalidConfigException $e) {
            static::attachDatabase();
            static::createSchema();
        }
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'support.trailers';
    }

    private static function attachDatabase()
    {
        $cmd = "ATTACH DATABASE '".dirname(__FILE__)."/../data/support.db' as support;";
        static::getDb()->createCommand($cmd)->execute();
    }

    private static function createSchema()
    {
        $schema = 'CREATE TABLE IF NOT EXISTS support.trailers (episode_id INTEGER PRIMARY KEY NOT NULL, youtube_id TEXT, last_check INTEGER);';
        static::getDb()->createCommand($schema)->execute();
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
