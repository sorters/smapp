<?php


class CategoryProductsCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function getAllProductsFromCategory(ApiTester $I)
    {
        $categoryId1 = '1';
        $categoryId2 = '2';

        $sampleCategories = array(
            array('id' => $categoryId1, 'name' => 'category1', 'description' => 'a test category description for 1'),
            array('id' => $categoryId2, 'name' => 'category2', 'description' => 'a test category description for 2'),
        );

        $sampleProductsIn = array(
            array('id' => '1', 'name' => 'product1', 'category_id' => $categoryId1,
                'description' => 'a test product description for 1'),
            array('id' => '2', 'name' => 'product2', 'category_id' => $categoryId1,
                'description' => 'a test product description for 2'),
            array('id' => '3', 'name' => 'product3', 'category_id' => $categoryId1,
                'description' => 'a test product description for 3'),
        );
        $sampleProductsOut = array(
            array('id' => '4', 'name' => 'product4', 'category_id' => $categoryId2,
                'description' => 'a test product description for 4'),
            array('id' => '5', 'name' => 'product5', 'category_id' => $categoryId2,
                'description' => 'a test product description for 5'),
        );

        $I->wantTo('retrieve all the products of a category via API');
        foreach($sampleCategories as $sampleCategory) {
            $I->haveInDatabase('categories', $sampleCategory);
        }
        foreach($sampleProductsIn as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        foreach($sampleProductsOut as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/categories/'.$categoryId1.'/products', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProductsIn);
        $I->dontSeeResponseContainsJson($sampleProductsOut);
    }

    public function setOneProductCategory(ApiTester $I) {
        $categoryId = '1';
        $productId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProductBefore = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');
        $sampleProductAfter = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $I->wantTo('set the category of a product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProductBefore);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/categories/'.$categoryId.'/products', ['products' => $productId]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('products', $sampleProductAfter);
    }

    public function setManyProductsCategory(ApiTester $I) {
        $categoryId = '1';
        $productId1 = '1';
        $productId2 = '2';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct1Before = array('id' => $productId1, 'name' => 'product1',
            'description' => 'a test product description for 1');
        $sampleProduct1After = array('id' => $productId1, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleProduct2Before = array('id' => $productId2, 'name' => 'product2',
            'description' => 'a test product description for 1');
        $sampleProduct2After = array('id' => $productId2, 'name' => 'product2', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $I->wantTo('set the category of many products via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct1Before);
        $I->haveInDatabase('products', $sampleProduct2Before);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/categories/'.$categoryId.'/products', ['products' => $productId1.','.$productId2]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('products', $sampleProduct1After);
        $I->seeInDatabase('products', $sampleProduct2After);

    }
}
