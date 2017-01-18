<?php


class CustomersCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function RetrieveAllCustomersTest(ApiTester $I)
    {
        $sampleCustomers =array(
            array('id' => '1', 'name' => 'customer1', 'description' => 'a test customer description for 1'),
            array('id' => '2', 'name' => 'customer2', 'description' => 'a test customer description for 2'),
            array('id' => '3', 'name' => 'customer3', 'description' => 'a test customer description for 3'),
        );

        $I->wantTo('retrieve all the customers via API');
        foreach($sampleCustomers as $sampleCustomer) {
            $I->haveInDatabase('customers', $sampleCustomer);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/customers', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleCustomers);
    }

    public function RetrieveOneCustomerTest(ApiTester $I)
    {
        $sampleCustomerId = '1';
        $sampleCustomer = array('id' => $sampleCustomerId, 'name' => 'customer', 'description' => 'a test customer description');

        $I->wantTo('retrieve a customer via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/customers/'.$sampleCustomerId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleCustomer);
    }

    public function RetrieveAnUnexistingCustomerTest(ApiTester $I)
    {
        $I->wantTo('check that attempting to retrieve an unexisting customer returns 404 via API');
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/customers/101', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); // 404
    }

    public function CreateCustomerTest(ApiTester $I)
    {
        $sampleCustomer = array('name' => 'customer', 'description' => 'a test customer description');

        $I->wantTo('create a customer via API');
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/customers', $sampleCustomer);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('customers', $sampleCustomer);
    }

    public function UpdateCustomerTest(ApiTester $I)
    {
        $sampleCustomerId = '1';
        $sampleCustomer = array('id' => $sampleCustomerId, 'name' => 'customer', 'description' => 'a test customer description');
        $sampleUpdatedCustomer = array('id' => $sampleCustomerId, 'name' => 'customer', 'description' => 'an updated test customer description');

        $I->wantTo('update an existing customer via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/customers', $sampleUpdatedCustomer);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('customers', $sampleUpdatedCustomer);
    }

    public function DeleteCustomerTest(ApiTester $I)
    {
        $sampleCustomerId = '1';
        $sampleCustomer = array('id' => $sampleCustomerId, 'name' => 'customer', 'description' => 'a test customer description');

        $I->wantTo('delete a customer via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/customers/'.$sampleCustomerId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->dontSeeInDatabase('customers', $sampleCustomer);
    }

    public function ListSaleOrdersForCustomerTest(ApiTester $I)
    {
        $categoryId = '1';

        $productId1 = '1';
        $productId2 = '2';

        $customerId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProducts = array(
            array('id' => $productId1, 'name' => 'product1', 'category_id' => $categoryId,
                'description' => 'a test product description for 1'),
            array('id' => $productId2, 'name' => 'product2', 'category_id' => $categoryId,
                'description' => 'a test product description for 1'),
        );

        $sampleCustomer = array('id' => $customerId, 'name' => 'provider1', 'description' => 'a test provider description for 1');

        $sampleSaleOrderId1 = '1';
        $sampleSaleOrderId2 = '2';
        $sampleSaleOrders = array(
            array('id' => $sampleSaleOrderId1, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment'),
            array('id' => $sampleSaleOrderId2, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment'),
        );

        $I->wantTo('list all the orders for a customer via API');
        $I->haveInDatabase('categories', $sampleCategory);
        foreach($sampleProducts as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
        }
        $I->haveInDatabase('customers', $sampleCustomer);
        foreach($sampleSaleOrders as $sampleSaleOrder) {
            $I->haveInDatabase('saleorders', $sampleSaleOrder);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/customers/'.$customerId.'/orders', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleSaleOrders);
    }

}
