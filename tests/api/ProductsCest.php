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
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
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
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
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
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
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
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
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
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/products/'.$productId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->dontSeeInDatabase('products', $sampleProduct);
    }

    public function SetProductStockTest(ApiTester $I)
    {
        $productId = '1';
        $quantity = 100;

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99');

        $sampleStock = array('product_id' => $productId, 'quantity' => $quantity);

        $I->wantTo('set the stock for a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->dontSeeInDatabase('stocks', array('product_id' => $productId));
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/refill/'.$quantity, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $quantity));
        $I->seeInDatabase('stocks', $sampleStock);
    }

    public function IncrementProductStockTest(ApiTester $I, \Codeception\Scenario $scenario)
    {
        $productId = '1';
        $currentQuantity = 100;
        $quantityToAdd = 10;

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99');

        $sampleStock = array('product_id' => $productId, 'quantity' => $currentQuantity);

        $I->wantTo('increment the stock for a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('stocks', $sampleStock);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/refill/'.$quantityToAdd, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $currentQuantity + $quantityToAdd));
        $I->seeInDatabase('stocks', array('product_id' => $productId, 'quantity' => $currentQuantity + $quantityToAdd));
    }

    public function DecrementProductStockTest(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = 100;
        $quantityToRemove = 10;

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99');

        $sampleStock = array('product_id' => $productId, 'quantity' => $currentQuantity);

        $I->wantTo('decrement the stock for a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('stocks', $sampleStock);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/remove/'.$quantityToRemove, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $currentQuantity - $quantityToRemove));
        $I->seeInDatabase('stocks', array('product_id' => $productId, 'quantity' => $currentQuantity - $quantityToRemove));
    }

    public function DecrementProductStockBelowZeroTest(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = 10;
        $quantityToRemove = 100;

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1', 'buy_price' => '10.0', 'sell_price' => '14.99');

        $sampleStock = array('product_id' => $productId, 'quantity' => $currentQuantity);

        $I->wantTo('decrement the stock below zero for a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('stocks', $sampleStock);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/remove/'.$quantityToRemove, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => true, "product_id" => $productId));
    }

}
