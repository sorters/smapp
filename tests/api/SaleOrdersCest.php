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
            array('id' => '1', 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment for 1'),
            array('id' => '2', 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment for 2'),
            array('id' => '3', 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment for 3'),
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

    public function RetrieveOneSaleOrderTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $I->wantTo('retrieve a sale order via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/saleorders/'.$sampleSaleOrderId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleSaleOrder);
    }

    public function RetrieveAnUnexistingSaleOrderTest(ApiTester $I)
    {
        $I->wantTo('check that attempting to retrieve an unexisting sale order returns 404 via API');
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/saleorders/101', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND); // 404
    }

    public function CreateSaleOrderTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $sampleSaleOrder = array('state' => true, 'customer_id' => $customerId, 'comments' => 'a test sale order comment');

        $I->wantTo('create a sale order via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/saleorders', $sampleSaleOrder);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('saleorders', $sampleSaleOrder);
    }

    public function UpdateSaleOrderTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');
        $sampleUpdatedSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'an updated test sale order comment');

        $I->wantTo('update an existing sale order via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/saleorders', $sampleUpdatedSaleOrder);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('saleorders', $sampleUpdatedSaleOrder);
    }

    public function DeleteSaleOrderTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => false, 'comments' => 'a test sale order comment');

        $I->wantTo('delete a sale order via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/saleorders/'.$sampleSaleOrderId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->dontSeeInDatabase('saleorders', $sampleSaleOrder);
    }

    public function AttemptToDeleteOpenSaleOrderTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $I->wantTo('verify that attempting to delete an open sale order gives a 400 via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/saleorders/'.$sampleSaleOrderId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
    }

    public function OpenSaleOrderTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => false, 'comments' => 'a test sale order comment');
        $sampleSaleOrderOpened = array('id' => $sampleSaleOrderId, 'state' => true, 'comments' => 'a test sale order comment');

        $I->wantTo('open a sale order via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/saleorders/'.$sampleSaleOrderId.'/open', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('saleorders', $sampleSaleOrderOpened);
    }

    public function CloseSaleOrderTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');
        $sampleSaleOrderClosed = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => false, 'comments' => 'a test sale order comment');

        $I->wantTo('close a sale order via API');
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/saleorders/'.$sampleSaleOrderId.'/close', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeInDatabase('saleorders', $sampleSaleOrderClosed);
    }

    public function CloseSaleOrderWithOpenLineTest(ApiTester $I)
    {
        $productId = '1';
        $sampleProduct = array('id' => $productId, 'name' => 'product1',
            'description' => 'a test product description for 1');

        $customerId = '1';
        $sampleProvider = array('id' => $customerId, 'name' => 'customer1', 'description' => 'a test customer description for 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $sampleSaleLineId = '1';
        $sampleSaleLine = array(
            'id' => $sampleSaleLineId,
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('check attempting to close a sale order with open sale lines fails via API');
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('customers', $sampleProvider);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveInDatabase('salelines', $sampleSaleLine);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/saleorders/'.$sampleSaleOrderId.'/close', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
    }

    public function ListSaleLinesFromSaleOrderTest(ApiTester $I)
    {
        $customerId = '1';
        $sampleCustomer = array('id' => $customerId, 'name' => 'customer 1', 'description' => 'description for customer 1');

        $categoryId = '1';
        $productId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $sampleSaleLines =array(
            array('id' => '1',
                'sale_order_id' => $sampleSaleOrderId,
                'product_id' => $productId,
                'state' => true,
                'units' => number_format(10, 2),
                'unit_price' => number_format(12.0, 2)),
            array('id' => '2',
                'sale_order_id' => $sampleSaleOrderId,
                'product_id' => $productId,
                'state' => true,
                'units' => number_format(100, 2),
                'unit_price' => number_format(9.0, 2))
        );

        $I->wantTo('list all the lines for a sale order via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        foreach($sampleSaleLines as $sampleSaleLine) {
            $I->haveInDatabase('salelines', $sampleSaleLine);
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/saleorders/'.$sampleSaleOrderId.'/lines', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleSaleLines);
    }






}
