<?php

namespace app\components;

use yii;

class LatestSqliteConnection extends yii\db\Connection
{
    const CONNECTION_STRING = 'sqlite:%s';

    /** @var string glob pattern to look for SQLite databases. */
    public $pattern;

    public function init()
    {
        $this->resolveConnectionString();
        parent::init();
    }

    private function resolveConnectionString()
    {
        if (empty($this->pattern))
            throw new yii\db\Exception('pattern cannot be empty.');

        $found = glob($this->pattern);
        $latest = end($found);
        if (empty($latest))
            throw new yii\db\Exception('No database found!');

        $this->dsn = sprintf(self::CONNECTION_STRING, $latest);
    }

}
