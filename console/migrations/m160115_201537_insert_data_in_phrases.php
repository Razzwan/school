<?php

use yii\db\Migration;
use app\models\Phrase;

class m160115_201537_insert_data_in_phrases extends Migration
{
    private $locales = ['ru', 'ua', 'en'];

    public function up()
    {
        $phrases_array = require Yii::getAlias('@t10s/phrases.php');
        foreach ($phrases_array as $name => $phrase) {
            foreach ($phrase as $locale => $text) {
                if (!is_numeric($locale)) {
                    $current_phrase = Phrase::find()
                        ->where(['name' => $name, 'locale' => $locale])
                        ->one();
                } else {
                    $current_phrase = Phrase::find()
                        ->where(['name' => $name, 'locale' => $this->locales[$locale]])
                        ->one();
                }

                if ($current_phrase === null) {
                    $current_phrase = new Phrase();
                }

                if (!$current_phrase->save()) {
                    echo "Не удалось сохранить поле {$name} проверьте правильность введенных данных\n";
                }
            }
        }

    }

    public function down()
    {
        echo "Для того, чтоб применить новые переводы просто запустите миграцию еще раз\n";
        return true;
    }
}
