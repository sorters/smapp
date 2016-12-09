<?php


class StocksCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function GetAllStocksTest(ApiTester $I)
    {
        $productId1 = 1;
        $productId2 = 2;

        $sampleProducts = array(
            array('id' => $productId1, 'name' => 'product1',
                'description' => 'a test product description for 1'),
            array('id' => $productId2, 'name' => 'product2',
                'description' => 'a test product description for 2')
        );

        $currentQuantity1 = number_format(100.0, 2);
        $currentQuantity2 = number_format(120.0, 2);

        $sampleStocks = array(
            array('product_id' => $productId1, 'quantity' => $currentQuantity1),
            array('product_id' => $productId2, 'quantity' => $currentQuantity2)
        );

        $I->wantTo('retrieve all the stocks via API');

        foreach($sampleProducts as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        foreach($sampleStocks as $sampleStock) {
            $I->haveInDatabase('stocks', $sampleStock);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/stocks', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleStocks);
    }
}
