<?php

use yii\db\Schema;
use yii\db\Migration;

class m151220_160519_all_from_folder extends Migration
{
    private $files = [];

    private $fileMap = [];

    private function _getAllFilesFromDir($dir)
    {
        if ($handle = opendir($dir)) {
            echo "Дескриптор каталога: $handle\n";
            echo "Файлы:\n";

            /* Именно этот способ чтения элементов каталога является правильным. */
            while (false !== ($file = readdir($handle))) {
                if($file != '..' && $file != '.'){
                    $this->files[] = $file;
                }
                echo "$file\n";
            }

            closedir($handle);
        }
        return $this->files;
    }

    public function safeUp()
    {
        $this->_getAllFilesFromDir(__DIR__.'/../sql');
    }

    public function safeDown()
    {
    }
}
