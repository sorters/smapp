<?php


class SaleOrdersCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function RetrieveAllSaleOrdersTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $sampleSaleOrders = array(
            array('id' => '1', 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test purchase order comment for 1'),
            array('id' => '2', 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test purchase order comment for 2'),
            array('id' => '3', 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test purchase order comment for 3'),
        );

        $I->wantTo('retrieve all the sale orders via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        foreach($sampleSaleOrders as $sampleSaleOrder) {
            $I->haveInDatabase('saleorders', $sampleSaleOrder);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/saleorders', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleSaleOrders);
    }
}
