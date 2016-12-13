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

        $sampleStock = array('product_id' => $productId, 'quantity' => $currentQuantity);

        $I->wantTo('check the stock of a product via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('stocks', $sampleStock);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/products/'.$productId.'/stock', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "product_id" => $productId, "quantity" => $currentQuantity));
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

    public function IncrementProductStockTest(ApiTester $I, \Codeception\Scenario $scenario)
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

}
