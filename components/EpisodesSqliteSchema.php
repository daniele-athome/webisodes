<?php

namespace app\components;

use yii;

class EpisodesSqliteSchema extends yii\db\sqlite\Schema
{

    protected function findColumns($table)
    {
        $parsed = explode('.', $table->name);
        if (count($parsed) > 1) {
            $sql = 'PRAGMA ' . $this->quoteSimpleTableName($parsed[0]) .
                '.table_info(' . $this->quoteSimpleTableName($parsed[1]) . ')';
        }
        else {
            $sql = 'PRAGMA table_info(' . $this->quoteSimpleTableName($table->name) . ')';
        }

        $columns = $this->db->createCommand($sql)->queryAll();
        if (empty($columns)) {
            return false;
        }

        foreach ($columns as $info) {
            $column = $this->loadColumnSchema($info);
            $table->columns[$column->name] = $column;
            if ($column->isPrimaryKey) {
                $table->primaryKey[] = $column->name;
            }
        }
        if (count($table->primaryKey) === 1 && !strncasecmp($table->columns[$table->primaryKey[0]]->dbType, 'int', 3)) {
            $table->sequenceName = '';
            $table->columns[$table->primaryKey[0]]->autoIncrement = true;
        }

        return true;
    }

}
