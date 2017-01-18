<?php


class ProductOffersCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function RetrieveAllProductOffersTest(ApiTester $I)
    {
        $sampleProducts = array(
            array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1'),
            array('id' => '2', 'name' => 'product2', 'description' => 'a test product description for 2'),
        );
        $sampleProviders =array(
            array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1'),
            array('id' => '2', 'name' => 'provider2', 'description' => 'a test provider description for 2'),
        );
        $sampleProductOffers =array(
            array('id' => '1', 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2)),
            array('id' => '2', 'product_id' => '1', 'provider_id' => '2', 'unit_price' => number_format(11.0, 2)),
            array('id' => '3', 'product_id' => '2', 'provider_id' => '1', 'unit_price' => number_format(120.0, 2)),
        );

        $I->wantTo('retrieve all the product offers via API');
        foreach($sampleProducts as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        foreach($sampleProviders as $sampleProvider) {
            $I->haveInDatabase('providers', $sampleProvider);
        }
        foreach($sampleProductOffers as $sampleProductOffer) {
            $I->haveInDatabase('productoffers', $sampleProductOffer);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/productoffers', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProductOffers);
    }

    public function RetrieveOneProductOfferTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $sampleProductOfferId = '1';
        $sampleProductOffer = array('id' => $sampleProductOfferId, 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));

        $I->wantTo('retrieve a product offer via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/productoffers/'.$sampleProductOfferId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleProductOffer);
    }

    public function CreateProductOfferTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $sampleProductOffer = array('product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));

        $I->wantTo('create a product offer via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/productoffers', $sampleProductOffer);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('productoffers', $sampleProductOffer);
    }

    public function UpdateProductOfferTest(ApiTester $I)
    {
        $sampleProductOfferId = '1';
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $sampleProductOffer = array('id' => $sampleProductOfferId, 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));
        $sampleUpdatedProductOffer = array('id' => $sampleProductOfferId, 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(10.0, 2));

        $I->wantTo('update an existing product offer via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/productoffers', $sampleUpdatedProductOffer);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('productoffers', $sampleUpdatedProductOffer);
    }

    public function DeleteProductOfferTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $sampleProductOfferId = '1';
        $sampleProductOffer = array('id' => $sampleProductOfferId, 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));

        $I->wantTo('delete a product offer via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/productoffers/'.$sampleProductOfferId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->dontSeeInDatabase('productoffers', $sampleProductOffer);
    }
}
