<?php


class ProvidersCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function RetrieveAllProvidersTest(ApiTester $I)
    {
        $sampleProviders =array(
            array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1'),
            array('id' => '2', 'name' => 'provider2', 'description' => 'a test provider description for 2'),
            array('id' => '3', 'name' => 'provider3', 'description' => 'a test provider description for 3'),
        );

        $I->wantTo('retrieve all the providers via API');
        foreach($sampleProviders as $sampleProvider) {
            $I->haveInDatabase('providers', $sampleProvider);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/providers', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProviders);
    }

    public function RetrieveOneProviderTest(ApiTester $I)
    {
        $sampleProviderId = '1';
        $sampleProvider = array('id' => $sampleProviderId, 'name' => 'provider', 'description' => 'a test provider description');

        $I->wantTo('retrieve a provider via API');
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/providers/'.$sampleProviderId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProvider);
    }

    public function RetrieveAnUnexistingProviderTest(ApiTester $I)
    {
        $I->wantTo('check that attempting to retrieve an unexisting provider returns 404 via API');
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/providers/101', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); // 404
    }

    public function CreateProviderTest(ApiTester $I)
    {
        $sampleProvider = array('name' => 'provider', 'description' => 'a test provider description');

        $I->wantTo('create a provider via API');
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/providers', $sampleProvider);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('providers', $sampleProvider);
    }

    public function UpdateProviderTest(ApiTester $I)
    {
        $sampleProviderId = '1';
        $sampleProvider = array('id' => $sampleProviderId, 'name' => 'provider', 'description' => 'a test provider description');
        $sampleUpdatedProvider = array('id' => $sampleProviderId, 'name' => 'provider', 'description' => 'an updated test provider description');

        $I->wantTo('update an existing provider via API');
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/providers', $sampleUpdatedProvider);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('providers', $sampleUpdatedProvider);
    }

    public function DeleteProviderTest(ApiTester $I)
    {
        $sampleProviderId = '1';
        $sampleProvider = array('id' => $sampleProviderId, 'name' => 'provider', 'description' => 'a test provider description');

        $I->wantTo('delete a provider via API');
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/providers/'.$sampleProviderId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->dontSeeInDatabase('providers', $sampleProvider);
    }

    public function ListPurchaseLinesFromPurchaseOrderTest(ApiTester $I)
    {
        $categoryId = '1';

        $productId1 = '1';
        $productId2 = '2';

        $providerId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProducts = array(
            array('id' => $productId1, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1'),
            array('id' => $productId2, 'name' => 'product2', 'category_id' => $categoryId,
                'description' => 'a test product description for 1'),
        );

        $sampleProvider = array('id' => $providerId, 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $samplePurchaseOrderId1 = '1';
        $samplePurchaseOrderId2 = '2';
        $samplePurchaseOrders = array(
            array('id' => $samplePurchaseOrderId1, 'state' => true, 'comments' => 'a test purchase order comment'),
            array('id' => $samplePurchaseOrderId2, 'state' => true, 'comments' => 'a test purchase order comment'),
        );

        $samplePurchaseLines =array(
            array('id' => '1',
                'purchase_order_id' => $samplePurchaseOrderId1,
                'product_id' => $productId1,
                'provider_id' => $providerId,
                'state' => true,
                'units' => number_format(10, 2),
                'unit_price' => number_format(12.0, 2)),
            array('id' => '2',
                'purchase_order_id' => $samplePurchaseOrderId2,
                'product_id' => $productId2,
                'provider_id' => $providerId,
                'state' => true,
                'units' => number_format(100, 2),
                'unit_price' => number_format(9.0, 2))
        );

        $I->wantTo('list all the lines for a provider via API');
        $I->haveInDatabase('categories', $sampleCategory);
        foreach($sampleProducts as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        $I->haveInDatabase('providers', $sampleProvider);
        foreach($samplePurchaseOrders as $samplePurchaseOrder) {
            $I->haveInDatabase('purchaseorders', $samplePurchaseOrder);
        }
        foreach($samplePurchaseLines as $samplePurchaseLine) {
            $I->haveInDatabase('purchaselines', $samplePurchaseLine);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/providers/'.$providerId.'/lines', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($samplePurchaseLines);
    }

    public function ListOffersForProviderTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId1 = '1';
        $productId2 = '2';
        $providerId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProducts = array(
            array('id' => $productId1, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1'),
            array('id' => $productId2, 'name' => 'product1', 'category_id' => $categoryId,
                'description' => 'a test product description for 1'),
        );

        $sampleProvider = array('id' => $providerId, 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $sampleProductOffers = array(
            array('id' => '1', 'unit_price' => number_format(9.0, 2), 'product_id' => $productId1, 'provider_id' => $providerId),
            array('id' => '2', 'unit_price' => number_format(8.0, 2), 'product_id' => $productId2, 'provider_id' => $providerId),
        );

        $I->wantTo('list all the product offers for a product via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('providers', $sampleProvider);
        foreach($sampleProducts as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        foreach($sampleProductOffers as $sampleProductOffer) {
            $I->haveInDatabase('productoffers', $sampleProductOffer);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/providers/'.$providerId.'/offers', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProductOffers);
    }


}
