<?php


class PurchaseLinesCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function RetrieveAPurchaseLineTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';
        $providerId1 = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleProvider = array('id' => $providerId1, 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');

        $samplePurchaseLineId = '1';
        $samplePurchaseLine = array(
            'id' => $samplePurchaseLineId,
            'purchase_order_id' => $samplePurchaseOrderId,
            'product_id' => $productId,
            'provider_id' => $providerId1,
            'state' => true,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('retrieve a purchase line via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveInDatabase('purchaselines', $samplePurchaseLine);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/purchaselines/'.$samplePurchaseLineId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($samplePurchaseLine);

    }

    public function CreatePurchaseLineTest(ApiTester $I) {
        $categoryId = '1';
        $productId = '1';
        $providerId1 = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleProvider = array('id' => $providerId1, 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');

        $samplePurchaseLine = array(
            'purchase_order_id' => $samplePurchaseOrderId,
            'product_id' => $productId,
            'provider_id' => $providerId1,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('create a purchase line via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/purchaselines', $samplePurchaseLine);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('purchaselines', $samplePurchaseLine);
    }

    public function UpdatePurchaseLineTest(ApiTester $I) {
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

        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');

        $samplePurchaseLineId = '1';
        $samplePurchaseLine = array(
            'id' => $samplePurchaseLineId,
            'purchase_order_id' => $samplePurchaseOrderId,
            'product_id' => $productId,
            'provider_id' => $providerId1,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $samplePurchaseLineUpdated = array(
            'id' => $samplePurchaseLineId,
            'purchase_order_id' => $samplePurchaseOrderId,
            'product_id' => $productId,
            'provider_id' => $providerId2,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('modify a purchase line via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        foreach($sampleProviders as $sampleProvider) {
            $I->haveInDatabase('providers', $sampleProvider);
        }
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveInDatabase('purchaselines', $samplePurchaseLine);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/purchaselines', $samplePurchaseLineUpdated);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('purchaselines', $samplePurchaseLineUpdated);
    }

    public function DeleteAPurchaseLineTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';
        $providerId1 = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleProvider = array('id' => $providerId1, 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');

        $samplePurchaseLineId = '1';
        $samplePurchaseLine = array(
            'id' => $samplePurchaseLineId,
            'purchase_order_id' => $samplePurchaseOrderId,
            'product_id' => $productId,
            'provider_id' => $providerId1,
            'state' => true,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('delete a purchase line via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveInDatabase('purchaselines', $samplePurchaseLine);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/purchaselines/'.$samplePurchaseLineId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->dontSeeInDatabase('purchaselines', $samplePurchaseLine);

    }

}
