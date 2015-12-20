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
}