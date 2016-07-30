<?php


class ProductsCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function RetrieveAllProductsTest(ApiTester $I)
    {
        $categoryId1 = '1';
        $categoryId2 = '2';

        $sampleCategories = array(
            array('id' => $categoryId1, 'name' => 'category1', 'description' => 'a test category description for 1'),
            array('id' => $categoryId2, 'name' => 'category2', 'description' => 'a test category description for 2'),
        );

        $sampleProducts = array(
            array('id' => '1', 'name' => 'product1', 'category_id' => $categoryId1,
                  'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99'),
            array('id' => '2', 'name' => 'product2', 'category_id' => $categoryId1,
                'description' => 'a test product description for 2', 'buy_price' => '100.0', 'sell_price' => '149.99'),
            array('id' => '3', 'name' => 'product3', 'category_id' => $categoryId2,
                'description' => 'a test product description for 3', 'buy_price' => '1.0', 'sell_price' => '2.5'),
        );

        $I->wantTo('retrieve all the products via API');
        foreach($sampleCategories as $sampleCategory) {
            $I->haveInDatabase('categories', $sampleCategory);
        }
        foreach($sampleProducts as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        $I->sendGET('/products', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProducts);
    }

    public function RetrieveOneProductTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
                'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99');

        $I->wantTo('retrieve one product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->sendGET('/products/'.$productId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProduct);
    }

    public function CreateProductTest(ApiTester $I)
    {
        $categoryId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99');

        $I->wantTo('create a product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->sendPOST('/products', $sampleProduct);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('products', $sampleProduct);
    }

    public function UpdateProductTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99');

        $I->wantTo('update a product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->sendPOST('/products', $sampleProduct);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('products', $sampleProduct);
    }

    public function DeleteProductTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99');

        $I->wantTo('delete a product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->sendDELETE('/products/'.$productId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->dontSeeInDatabase('products', $sampleProduct);
    }
}
