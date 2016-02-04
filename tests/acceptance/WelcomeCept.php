<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Убедиться, что главная работает');
$I->amOnPage('/');
$I->see('Congratulations!');
$I->see('You have successfully created your Yii-powered application.');
$I->see('Heading');
$I->see('My Company');
