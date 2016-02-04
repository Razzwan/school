<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Убедиться, что страница about работает');
$I->amOnPage('/site/about');
$I->see('About');
