<?php

use yii\db\Migration;

class m160115_200807_create_table_phrases extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%phrases}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'locale' => $this->string(2),
            'text' => $this->text(),
        ]);

        $this->createIndex('name_locale', '{{%phrases}}', ['name', 'locale'], true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%phrases}}');
    }
}
