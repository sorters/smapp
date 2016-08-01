<?php


class CategoriesCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function RetrieveAllCategoriesTest(ApiTester $I)
    {
        $sampleCategories =array(
            array('id' => '1', 'name' => 'category1', 'description' => 'a test category description for 1'),
            array('id' => '2', 'name' => 'category2', 'description' => 'a test category description for 2'),
            array('id' => '3', 'name' => 'category3', 'description' => 'a test category description for 3'),
        );

        $I->wantTo('retrieve all the categories via API');
        foreach($sampleCategories as $sampleCategory) {
            $I->haveInDatabase('categories', $sampleCategory);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/categories', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleCategories);
    }

    public function RetrieveOneCategoryTest(ApiTester $I)
    {
        $sampleCategoryId = '1';
        $sampleCategory = array('id' => $sampleCategoryId, 'name' => 'category', 'description' => 'a test category description');

        $I->wantTo('retrieve a category via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/categories/'.$sampleCategoryId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleCategory);
    }

    public function CreateCategoryTest(ApiTester $I)
    {
        $sampleCategory = array('name' => 'category', 'description' => 'a test category description');

        $I->wantTo('create a category via API');
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/categories', $sampleCategory);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('categories', $sampleCategory);
    }

    public function UpdateCategorytest(ApiTester $I)
    {
        $sampleCategoryId = '1';
        $sampleCategory = array('id' => $sampleCategoryId, 'name' => 'category', 'description' => 'a test category description');
        $sampleUpdatedCategory = array('id' => $sampleCategoryId, 'name' => 'category', 'description' => 'an updated test category description');

        $I->wantTo('update and existing category via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/categories', $sampleUpdatedCategory);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('categories', $sampleUpdatedCategory);
    }

    public function DeleteCategoryTest(ApiTester $I)
    {
        $sampleCategoryId = '1';
        $sampleCategory = array('id' => $sampleCategoryId, 'name' => 'category', 'description' => 'a test category description');

        $I->wantTo('delete a category via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/categories/'.$sampleCategoryId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->dontSeeInDatabase('categories', $sampleCategory);
    }
}
