<?php

use yii\db\Schema;
use yii\db\Migration;

class m151220_123507_file_put_content extends Migration
{
    /**
     * Пример миграции загруженой из файла
     */
    public function safeUp()
    {
        $query = file_get_contents(__DIR__ . '/../sql/1.sql');

        $this->execute($query);
    }

    /**
     * Пример необратимой миграции
     * @return bool
     */
    public function safeDown()
    {
        echo "Миграция m151220_123507_file_put_content необратима!\n";
        return false;
    }
}
