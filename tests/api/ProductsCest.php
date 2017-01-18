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
                  'description' => 'a test product description for 1'),
            array('id' => '2', 'name' => 'product2', 'category_id' => $categoryId1,
                'description' => 'a test product description for 2'),
            array('id' => '3', 'name' => 'product3', 'category_id' => $categoryId2,
                'description' => 'a test product description for 3'),
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
                'description' => 'a test product description for 1');

        $I->wantTo('retrieve one product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProduct);
    }

    public function RetrieveInexistentProductGives404Test(ApiTester $I)
    {
        $fakeProductId = '9999';

        $fakeSampleProduct = array('id' => $fakeProductId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $I->wantTo('Get a 404 response while attempting to retrieve an inexistent product via API');
        $I->dontSeeInDatabase('products', $fakeSampleProduct);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$fakeProductId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); // 404
    }

    public function CreateProductTest(ApiTester $I)
    {
        $categoryId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

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
            'description' => 'a test product description for 1');

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
            'description' => 'a test product description for 1');

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
        $quantity = number_format(100.0, 2);

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

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

    public function GetProductStock(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = number_format(100.0, 2);

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleStocks = array(
            array('id' => '1', 'product_id' => $productId, 'quantity' => $currentQuantity),
            array('id' => '2', 'product_id' => $productId, 'quantity' => $currentQuantity),
            array('id' => '3', 'product_id' => $productId, 'quantity' => $currentQuantity),
            array('id' => '4', 'product_id' => $productId, 'quantity' => $currentQuantity)
        );

        $expectedQuantity = number_format(100.0 * count($sampleStocks), 2);

        $I->wantTo('check the stock of a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        foreach ($sampleStocks as $sampleStock) {
            $I->haveInDatabase('stocks', $sampleStock);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/stock', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $expectedQuantity));
    }

    public function Get0AsStockForProductWithNoStock(ApiTester $I) {
        $productId = '1';
        $expectedQuantity = number_format(0.0, 2);

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $I->wantTo('check that I get 0 for a stock of a product that has no stock via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/stock', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $expectedQuantity));
    }

    public function GetProductStocks(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = number_format(100.0, 2);

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleStocks = array(
            array('id' => '1', 'product_id' => $productId, 'quantity' => $currentQuantity),
            array('id' => '2', 'product_id' => $productId, 'quantity' => $currentQuantity),
            array('id' => '3', 'product_id' => $productId, 'quantity' => $currentQuantity),
            array('id' => '4', 'product_id' => $productId, 'quantity' => $currentQuantity)
        );

        $I->wantTo('list the stocks of a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        foreach ($sampleStocks as $sampleStock) {
            $I->haveInDatabase('stocks', $sampleStock);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/stocks');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "stocks" => $sampleStocks));
    }

    public function GetEmptyListAsStocksForProductWithNoStocks(ApiTester $I) {
        $productId = '1';

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $I->wantTo('check that I get an empty list for a product that has no stocks via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/stocks', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "stocks" => array()));
    }

    public function IncrementProductStockTest(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = number_format(100.0, 2);
        $quantityToAdd = 10;

        $expectedQuantity = number_format($currentQuantity + $quantityToAdd, 2);

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleStock = array('product_id' => $productId, 'quantity' => $currentQuantity);

        $I->wantTo('increment the stock for a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('stocks', $sampleStock);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/refill/'.$quantityToAdd, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $expectedQuantity));
        $I->seeInDatabase('stocks', array('product_id' => $productId, 'quantity' => $expectedQuantity));
    }

    public function IncrementProductStockWithNewStockTest(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = number_format(100.0, 2);
        $quantityToAdd = 10;

        $expectedQuantity = number_format($currentQuantity + $quantityToAdd, 2);

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleStock = array('id' => 1, 'product_id' => $productId, 'quantity' => $currentQuantity);

        $sampleNewStock =  array('id' => 2, 'product_id' => $productId, 'quantity' => $quantityToAdd);

        $I->wantTo('increment the stock for a product by creating a new stock via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('stocks', $sampleStock);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/refill/'.$quantityToAdd, array('mode' => 'create'));
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $expectedQuantity));
        $I->seeInDatabase('stocks', $sampleStock);
        $I->seeInDatabase('stocks', $sampleNewStock);
    }

    public function DecrementProductStockTest(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = 100.0;
        $quantityToRemove = 10;

        $expectedQuantity = number_format($currentQuantity - $quantityToRemove, 2);

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleStock = array('product_id' => $productId, 'quantity' => $currentQuantity);

        $I->wantTo('decrement the stock for a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('stocks', $sampleStock);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/remove/'.$quantityToRemove, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $expectedQuantity));
        $I->seeInDatabase('stocks', array('product_id' => $productId, 'quantity' => $expectedQuantity));
    }

    public function DecrementSpecificProductStockTest(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = 100.0;
        $quantityToRemove = 110;


        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleStocks = array(
            array('id' => 1, 'product_id' => $productId, 'quantity' => $currentQuantity),
            array('id' => 2, 'product_id' => $productId, 'quantity' => $currentQuantity),
            array('id' => 3, 'product_id' => $productId, 'quantity' => $currentQuantity),
        );

        $expectedQuantity = number_format($currentQuantity * count($sampleStocks) - $quantityToRemove, 2);

        $expectedStocks = array(
            array('id' => 1, 'product_id' => $productId, 'quantity' => 90),
            array('id' => 2, 'product_id' => $productId, 'quantity' => 0),
            array('id' => 3, 'product_id' => $productId, 'quantity' => $currentQuantity),
        );

        $I->wantTo('decrement a specific stock for a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        foreach ($sampleStocks as $sampleStock) {
            $I->haveInDatabase('stocks', $sampleStock);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/remove/'.$quantityToRemove.'/2', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $expectedQuantity));
        foreach ($expectedStocks as $expectedStock) {
            $I->seeInDatabase('stocks', $expectedStock);
        }
    }

    public function DecrementProductStockBelowZeroTest(ApiTester $I)
    {
        $productId = '1';
        $currentQuantity = 10;
        $quantityToRemove = 100;

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleStock = array('product_id' => $productId, 'quantity' => $currentQuantity);

        $I->wantTo('decrement the stock below zero for a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('stocks', $sampleStock);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/remove/'.$quantityToRemove, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
    }

    public function AddTagToProductTest(ApiTester $I)
    {
        $productId = '1';
        $expectedTagId = '1';

        $sampleTagName = 'sampletag';

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleTagBody = array('tag' => $sampleTagName);
        $expectedTag = array('id' => $expectedTagId, 'name' => $sampleTagName);

        $I->wantTo('add a tag to a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/tag', $sampleTagBody);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('tags', $expectedTag);
        $I->seeInDatabase('product_tag', array('product_id' => $productId, 'tag_id' => $expectedTagId));
    }

    public function RemoveTagFromProductTest(ApiTester $I)
    {
        $productId = '1';
        $sampleTagId1 = '1';
        $sampleTagId2 = '2';

        $sampleTagName1 = 'sampletag1';
        $sampleTagName2 = 'sampletag2';

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $sampleTagBody = array('tag' => $sampleTagName1);

        $expectedTagsAlways = array(
            array('id' => $sampleTagId1, 'name' => $sampleTagName1),
            array('id' => $sampleTagId2, 'name' => $sampleTagName2),
        );

        $I->wantTo('remove a tag from a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        foreach($expectedTagsAlways as $expectedTag) {
            $I->haveInDatabase('tags', $expectedTag);
            $I->haveInDatabase('product_tag', array('tag_id' => $expectedTag['id'], 'product_id' => $sampleProduct['id']));
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/products/'.$productId.'/untag', $sampleTagBody);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        foreach($expectedTagsAlways as $expectedTag) {
            $I->seeInDatabase('tags', $expectedTag);
        }
        $I->seeInDatabase('product_tag', array('product_id' => $productId, 'tag_id' => $sampleTagId2));
        $I->dontSeeInDatabase('product_tag', array('product_id' => $productId, 'tag_id' => $sampleTagId1));
    }

    public function GetTagsForProductTest(ApiTester $I)
    {
        $productId = '1';

        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $expectedTags = array(
            array('id' => '1', 'name' => 'sampletag1'),
            array('id' => '2', 'name' => 'sampletag2'),
        );

        $I->wantTo('get the tags of a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        foreach($expectedTags as $expectedTag) {
            $I->haveInDatabase('tags', $expectedTag);
            $I->haveInDatabase('product_tag', array('tag_id' => $expectedTag['id'], 'product_id' => $sampleProduct['id']));
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/tags');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "tags" => $expectedTags));
    }

    public function ListPurchaseLinesForProductTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';
        $providerId1 = '1';
        $providerId2 = '2';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleProviders = array(
            array('id' => $providerId1, 'name' => 'provider1', 'description' => 'a test provider description for 1'),
            array('id' => $providerId2, 'name' => 'provider2', 'description' => 'a test provider description for 2'),
        );

        $samplePurchaseOrderId1 = '1';
        $samplePurchaseOrderId2 = '2';
        $samplePurchaseOrders = array(
            array('id' => $samplePurchaseOrderId1, 'state' => true, 'comments' => 'a test purchase order comment'),
            array('id' => $samplePurchaseOrderId2, 'state' => true, 'comments' => 'a test purchase order comment'),
        );

        $samplePurchaseLines =array(
            array('id' => '1',
                'purchase_order_id' => $samplePurchaseOrderId1,
                'product_id' => $productId,
                'provider_id' => $providerId1,
                'state' => true,
                'units' => number_format(10, 2),
                'unit_price' => number_format(12.0, 2)),
            array('id' => '2',
                'purchase_order_id' => $samplePurchaseOrderId2,
                'product_id' => $productId,
                'provider_id' => $providerId2,
                'state' => true,
                'units' => number_format(100, 2),
                'unit_price' => number_format(9.0, 2))
        );

        $I->wantTo('list all the purchase lines for a product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        foreach($sampleProviders as $sampleProvider) {
            $I->haveInDatabase('providers', $sampleProvider);
        }
        foreach($samplePurchaseOrders as $samplePurchaseOrder) {
            $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        }
        foreach($samplePurchaseLines as $samplePurchaseLine) {
            $I->haveInDatabase('purchaselines', $samplePurchaseLine);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/purchaselines', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($samplePurchaseLines);
    }

    public function ListSaleLinesForProductTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';
        $providerId1 = '1';
        $providerId2 = '2';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleProviders = array(
            array('id' => $providerId1, 'name' => 'provider1', 'description' => 'a test provider description for 1'),
            array('id' => $providerId2, 'name' => 'provider2', 'description' => 'a test provider description for 2'),
        );

        $sampleSaleOrderId1 = '1';
        $sampleSaleOrderId2 = '2';
        $sampleSaleOrders = array(
            array('id' => $sampleSaleOrderId1, 'state' => true, 'comments' => 'a test sale order comment'),
            array('id' => $sampleSaleOrderId2, 'state' => true, 'comments' => 'a test sale order comment'),
        );

        $sampleSaleLines =array(
            array('id' => '1',
                'sale_order_id' => $sampleSaleOrderId1,
                'product_id' => $productId,
                'state' => true,
                'units' => number_format(10, 2),
                'unit_price' => number_format(12.0, 2)),
            array('id' => '2',
                'sale_order_id' => $sampleSaleOrderId2,
                'product_id' => $productId,
                'state' => true,
                'units' => number_format(100, 2),
                'unit_price' => number_format(9.0, 2))
        );

        $I->wantTo('list all the sale lines for a product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        foreach($sampleProviders as $sampleProvider) {
            $I->haveInDatabase('providers', $sampleProvider);
        }
        $I->haveInDatabase('products', $sampleProduct);
        foreach($sampleSaleOrders as $sampleSaleOrder) {
            $I->haveInDatabase('saleorders', $sampleSaleOrder);
        }
        foreach($sampleSaleLines as $sampleSaleLine) {
            $I->haveInDatabase('salelines', $sampleSaleLine);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/salelines', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleSaleLines);
    }

    public function ListOffersForProductTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';
        $providerId1 = '1';
        $providerId2 = '2';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleProviders = array(
            array('id' => $providerId1, 'name' => 'provider1', 'description' => 'a test provider description for 1'),
            array('id' => $providerId2, 'name' => 'provider2', 'description' => 'a test provider description for 2'),
        );

        $sampleProductOffers = array(
            array('id' => '1', 'unit_price' => number_format(9.0, 2), 'product_id' => $productId, 'provider_id' => $providerId1),
            array('id' => '2', 'unit_price' => number_format(8.0, 2), 'product_id' => $productId, 'provider_id' => $providerId2),
        );

        $I->wantTo('list all the product offers for a product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        foreach($sampleProviders as $sampleProvider) {
            $I->haveInDatabase('providers', $sampleProvider);
        }
        $I->haveInDatabase('products', $sampleProduct);
        foreach($sampleProductOffers as $sampleProductOffer) {
            $I->haveInDatabase('productoffers', $sampleProductOffer);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/offers', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProductOffers);
    }

}
