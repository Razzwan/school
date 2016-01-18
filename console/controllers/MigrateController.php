<?php
namespace console\controllers;

use yii\console\Exception;
use yii\helpers\Console;

class MigrateController extends \yii\console\controllers\MigrateController
{
    public $templateFile = __DIR__ .'/../views/migration.php';

    public $translationsTemplateFile;

    public function actionCreateTransfer($file_name)
    {
        if (!preg_match('/^\w+$/', $file_name)) {
            throw new Exception("The migration file name should contain letters, digits and/or underscore characters only.");
        }

        $name = 'm' . gmdate('ymd_His') . '_' . 'translations';
        $file = $this->migrationPath . DIRECTORY_SEPARATOR . 'translations' . '.php';

        if (!preg_match('/\.php$/', $file_name)) {
            $file_name .= $file_name . ".php";
        }

        if ($this->confirm("Create new migration '$file'?")) {
            $content = $this->renderFile(\Yii::getAlias($this->translationsTemplateFile), ['className' => $name, 'fileName' => $file_name]);
            file_put_contents($file, $content);
            $this->stdout("New migration created successfully.\n", Console::FG_GREEN);
        }
    }
}