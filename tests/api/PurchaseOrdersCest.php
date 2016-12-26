<?php


class PurchaseOrdersCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function RetrieveAllPurchaseOrdersTest(ApiTester $I)
    {
        $samplePurchaseOrders =array(
            array('id' => '1', 'state' => true, 'comments' => 'a test purchase order comment for 1'),
            array('id' => '2', 'state' => true, 'comments' => 'a test purchase order comment for 2'),
            array('id' => '3', 'state' => true, 'comments' => 'a test purchase order comment for 3'),
        );

        $I->wantTo('retrieve all the purchase orders via API');
        foreach($samplePurchaseOrders as $samplePurchaseOrder) {
            $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/purchaseorders', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($samplePurchaseOrders);
    }

    public function RetrieveOnePurchaseOrderTest(ApiTester $I)
    {
        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');

        $I->wantTo('retrieve a purchase order via API');
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/purchaseorders/'.$samplePurchaseOrderId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($samplePurchaseOrder);
    }

    public function RetrieveAnUnexistingPurchaseOrderTest(ApiTester $I)
    {
        $I->wantTo('check that attempting to retrieve an unexisting purchase order returns 404 via API');
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/purchaseorders/101', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); // 404
    }

    public function CreatePurchaseOrderTest(ApiTester $I)
    {
        $samplePurchaseOrder = array('state' => true, 'comments' => 'a test purchase order comment');

        $I->wantTo('create a purchase order via API');
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/purchaseorders', $samplePurchaseOrder);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('purchaseorders', $samplePurchaseOrder);
    }

    public function UpdatePurchaseOrderTest(ApiTester $I)
    {
        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');
        $sampleUpdatedPurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'an updated test purchase order comment');

        $I->wantTo('update an existing purchaseorder via API');
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/purchaseorders', $sampleUpdatedPurchaseOrder);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('purchaseorders', $sampleUpdatedPurchaseOrder);
    }

    public function DeletePurchaseOrderTest(ApiTester $I)
    {
        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');

        $I->wantTo('delete a purchase order via API');
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/purchaseorders/'.$samplePurchaseOrderId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->dontSeeInDatabase('purchaseorders', $samplePurchaseOrder);
    }

    public function OpenPurchaseOrderTest(ApiTester $I)
    {
        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => false, 'comments' => 'a test purchase order comment');
        $samplePurchaseOrderOpened = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');

        $I->wantTo('open a purchase order via API');
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/purchaseorders/'.$samplePurchaseOrderId.'/open', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('purchaseorders', $samplePurchaseOrderOpened);
    }

    public function ClosePurchaseOrderTest(ApiTester $I)
    {
        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');
        $samplePurchaseOrderClosed = array('id' => $samplePurchaseOrderId, 'state' => false, 'comments' => 'a test purchase order comment');

        $I->wantTo('close a purchase order via API');
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/purchaseorders/'.$samplePurchaseOrderId.'/close', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('purchaseorders', $samplePurchaseOrderClosed);
    }

    public function ListPurchaseLinesFromPurchaseOrderTest(ApiTester $I)
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

        $samplePurchaseOrderId = '1';
        $samplePurchaseOrder = array('id' => $samplePurchaseOrderId, 'state' => true, 'comments' => 'a test purchase order comment');

        $samplePurchaseLines =array(
            array('id' => '1',
                'purchase_order_id' => $samplePurchaseOrderId,
                'product_id' => $productId,
                'provider_id' => $providerId1,
                'state' => true,
                'units' => number_format(10, 2),
                'unit_price' => number_format(12.0, 2)),
            array('id' => '2',
                'purchase_order_id' => $samplePurchaseOrderId,
                'product_id' => $productId,
                'provider_id' => $providerId2,
                'state' => true,
                'units' => number_format(100, 2),
                'unit_price' => number_format(9.0, 2))
        );

        $I->wantTo('list all the lines for a purchase order via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        foreach($sampleProviders as $sampleProvider) {
            $I->haveInDatabase('providers', $sampleProvider);
        }
        $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        foreach($samplePurchaseLines as $samplePurchaseLine) {
            $I->haveInDatabase('purchaselines', $samplePurchaseLine);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/purchaseorders/'.$samplePurchaseOrderId.'/lines', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($samplePurchaseLines);
    }
}
