<?php


class TriggersCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function RetrieveAllTriggersTest(ApiTester $I)
    {
        $sampleProducts = array(
            array('id' => '1', 'name' => 'product1',
                  'description' => 'a test product description for 1'),
            array('id' => '2', 'name' => 'product2',
                'description' => 'a test product description for 2'),
            array('id' => '3', 'name' => 'product3',
                'description' => 'a test product description for 3'),
        );

        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $sampleProductOffers =array(
            array('id' => '1', 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2)),
            array('id' => '2', 'product_id' => '2', 'provider_id' => '1', 'unit_price' => number_format(11.0, 2)),
            array('id' => '3', 'product_id' => '3', 'provider_id' => '1', 'unit_price' => number_format(120.0, 2)),
        );

        $sampleTriggers = array(
            array('id' => '1', 'threshold' => '120', 'offset' => '20', 'fill' => true, 'enabled' => true, 'product_id' => '1', 'product_offer_id' => '1'),
            array('id' => '2', 'threshold' => '200', 'offset' => '0', 'fill' => true, 'enabled' => true, 'product_id' => '2', 'product_offer_id' => '2'),
            array('id' => '3', 'threshold' => '10', 'offset' => '20', 'fill' => false, 'enabled' => true, 'product_id' => '3', 'product_offer_id' => '3'),
        );

        $I->wantTo('retrieve all the triggers via API');
        foreach($sampleProducts as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        $I->haveInDatabase('providers', $sampleProvider);
        foreach($sampleProductOffers as $sampleProductOffer) {
            $I->haveInDatabase('productoffers', $sampleProductOffer);
        }
        foreach($sampleTriggers as $sampleTrigger) {
            $I->haveInDatabase('triggers', $sampleTrigger);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/triggers', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleTriggers);
    }

    public function RetrieveOneTriggerTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');
        $sampleProductOffer = array('id' => '1', 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));

        $sampleTriggerId = '1';
        $sampleTrigger = array('id' => $sampleTriggerId, 'threshold' => '120', 'offset' => '20', 'fill' => true, 'enabled' => true, 'product_id' => '1', 'product_offer_id' => '1');

        $I->wantTo('retrieve a trigger via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveInDatabase('triggers', $sampleTrigger);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/triggers/'.$sampleTriggerId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleTrigger);
    }

    public function CreateTriggerTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');
        $sampleProductOffer = array('id' => '1', 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));

        $sampleTrigger = array('threshold' => '120', 'offset' => '20', 'fill' => true, 'enabled' => true, 'product_id' => '1', 'product_offer_id' => '1');

        $I->wantTo('create a trigger via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/triggers', $sampleTrigger);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('triggers', $sampleTrigger);
    }

    public function UpdateTriggerTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');
        $sampleProductOffer = array('id' => '1', 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));
        
        $sampleTriggerId = '1';
        $sampleTrigger = array('id' => $sampleTriggerId, 'threshold' => '120', 'offset' => '20', 'fill' => false, 'enabled' => true, 'product_id' => '1', 'product_offer_id' => '1');
        $sampleUpdatedTrigger = array('id' => $sampleTriggerId, 'threshold' => '100', 'offset' => '10', 'fill' => true, 'enabled' => true, 'product_id' => '1', 'product_offer_id' => '1');

        $I->wantTo('update an existing trigger via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveInDatabase('triggers', $sampleTrigger);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/triggers', $sampleUpdatedTrigger);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('triggers', $sampleUpdatedTrigger);
    }

    public function DeleteTriggerTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');
        $sampleProductOffer = array('id' => '1', 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));

        $sampleTriggerId = '1';
        $sampleTrigger = array('id' => $sampleTriggerId, 'threshold' => '120', 'offset' => '20', 'fill' => true, 'enabled' => true, 'product_id' => '1', 'product_offer_id' => '1');

        $I->wantTo('delete a trigger via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveInDatabase('triggers', $sampleTrigger);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/triggers/'.$sampleTriggerId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->dontSeeInDatabase('triggers', $sampleTrigger);
    }

    public function EnableTriggerTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');
        $sampleProductOffer = array('id' => '1', 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));

        $sampleTriggerId = '1';
        $sampleTrigger = array('id' => $sampleTriggerId, 'threshold' => '120', 'offset' => '20', 'fill' => true, 'enabled' => false, 'product_id' => '1', 'product_offer_id' => '1');
        $sampleTriggerEnabled = array('id' => $sampleTriggerId, 'threshold' => '120', 'offset' => '20', 'fill' => true, 'enabled' => true, 'product_id' => '1', 'product_offer_id' => '1');


        $I->wantTo('enable a trigger via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveInDatabase('triggers', $sampleTrigger);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/triggers/'.$sampleTriggerId.'/enable', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('triggers', $sampleTriggerEnabled);
    }

    public function DisableTriggerTest(ApiTester $I)
    {
        $sampleProduct = array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1');
        $sampleProvider = array('id' => '1', 'name' => 'provider1', 'description' => 'a test provider description for 1');
        $sampleProductOffer = array('id' => '1', 'product_id' => '1', 'provider_id' => '1', 'unit_price' => number_format(12.0, 2));

        $sampleTriggerId = '1';
        $sampleTrigger = array('id' => $sampleTriggerId, 'threshold' => '120', 'offset' => '20', 'fill' => true, 'enabled' => true, 'product_id' => '1', 'product_offer_id' => '1');
        $sampleTriggerDisabled = array('id' => $sampleTriggerId, 'threshold' => '120', 'offset' => '20', 'fill' => true, 'enabled' => false, 'product_id' => '1', 'product_offer_id' => '1');

        $I->wantTo('disable a trigger via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('providers', $sampleProvider);
        $I->haveInDatabase('productoffers', $sampleProductOffer);
        $I->haveInDatabase('triggers', $sampleTrigger);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/triggers/'.$sampleTriggerId.'/disable', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('triggers', $sampleTriggerDisabled);
    }

}
