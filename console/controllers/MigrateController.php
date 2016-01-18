<?php
/**
 * Created by PhpStorm.
 * User: r
 * Date: 20.12.15
 * Time: 14:52
 */

namespace console\controllers;

class MigrateController extends \yii\console\controllers\MigrateController
{
    public $templateFile = __DIR__ .'/../views/migration.php';

    public $translationsTemplateFile;

    public function actionCreateTransfer($name = 'translations')
    {
        if (!preg_match('/^\w+$/', $name)) {
            throw new Exception("The migration name should contain letters, digits and/or underscore characters only.");
        }

        $name = 'm' . gmdate('ymd_His') . '_' . $name;
        $file = $this->migrationPath . DIRECTORY_SEPARATOR . $name . '.php';

        if ($this->confirm("Create new migration '$file'?")) {
            $content = $this->renderFile(\Yii::getAlias($this->translationsTemplateFile), ['className' => $name]);
            file_put_contents($file, $content);
            $this->stdout("New migration created successfully.\n", Console::FG_GREEN);
        }
    }
}