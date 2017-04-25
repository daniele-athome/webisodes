<?php

namespace app\components;

use yii;

class EpisodesSqliteConnection extends LatestSqliteConnection
{
    private $_schema;

    private $_attached = false;

    public function init()
    {
        parent::init();
        if (!$this->_attached) {
            $this->attachDatabase();
            $this->createSchema();
            $this->_attached = true;
        }
    }

    private function attachDatabase()
    {
        $cmd = "ATTACH DATABASE '".dirname(__FILE__)."/../data/support.db' as support;";
        $this->createCommand($cmd)->execute();
    }

    private function createSchema()
    {
        $schema = 'CREATE TABLE IF NOT EXISTS support.trailers (episode_id INTEGER PRIMARY KEY NOT NULL, youtube_id TEXT, last_check INTEGER);';
        $this->createCommand($schema)->execute();
    }

    public function getSchema()
    {
        if ($this->_schema !== null) {
            return $this->_schema;
        } else {
            $config = ['class' => EpisodesSqliteSchema::className()];
            $config['db'] = $this;
            return $this->_schema = Yii::createObject($config);
        }
    }

}
