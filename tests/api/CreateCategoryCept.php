<?php 
$I = new ApiTester($scenario);

$I->wantTo('create a category via API');
$I->sendPOST('/categories', ['name' => 'testCategory', 'description' => 'descriptive test description']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
$I->seeResponseIsJson();
$I->seeResponseContains('"errors":false');
$I->seeInDatabase('categories', array('name' => 'testCategory', 'description' => 'descriptive test description'));