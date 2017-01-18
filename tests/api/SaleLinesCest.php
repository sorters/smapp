<?php


class SaleLinesCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function RetrieveASaleLineTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';
        $customerId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleCustomer = array('id' => $customerId, 'name' => 'customer1', 'description' => 'a test customer description for 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $sampleSaleLineId = '1';
        $sampleSaleLine = array(
            'id' => $sampleSaleLineId,
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'state' => true,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('retrieve a sale line via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveInDatabase('salelines', $sampleSaleLine);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/salelines/'.$sampleSaleLineId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson($sampleSaleLine);

    }

    public function CreateSaleLineTest(ApiTester $I) {
        $categoryId = '1';
        $productId = '1';
        $customerId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleCustomer = array('id' => $customerId, 'name' => 'customer1', 'description' => 'a test customer description for 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $sampleSaleLine = array(
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('create a sale line via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/salelines', $sampleSaleLine);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('salelines', $sampleSaleLine);
    }

    public function UpdateSaleLineTest(ApiTester $I) {
        $categoryId = '1';

        $productId = '1';

        $customerId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleCustomer = array('id' => $customerId, 'name' => 'customer1', 'description' => 'a test customer description for 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $sampleSaleLineId = '1';
        $sampleSaleLine = array(
            'id' => $sampleSaleLineId,
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $sampleSaleLineUpdated = array(
            'id' => $sampleSaleLineId,
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'units' => number_format(20, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('modify a sale line via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveInDatabase('salelines', $sampleSaleLine);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/salelines', $sampleSaleLineUpdated);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('salelines', $sampleSaleLineUpdated);
    }

    public function DeleteASaleLineTest(ApiTester $I)
    {
        $categoryId = '1';
        $productId = '1';
        $customerId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleCustomer = array('id' => $customerId, 'name' => 'customer1', 'description' => 'a test customer description for 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $sampleSaleLineId = '1';
        $sampleSaleLine = array(
            'id' => $sampleSaleLineId,
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'state' => true,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('delete a sale line via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveInDatabase('salelines', $sampleSaleLine);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendDELETE('/salelines/'.$sampleSaleLineId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->dontSeeInDatabase('salelines', $sampleSaleLine);

    }

    public function AssignSaleLineToSaleOrderTest(ApiTester $I) {
        $categoryId = '1';

        $productId = '1';

        $customerId1 = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleCustomer = array('id' => $customerId1, 'name' => 'customer1', 'description' => 'a test customer description for 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId1, 'state' => true, 'comments' => 'a test sale order comment');

        $sampleSaleLineId = '1';
        $sampleSaleLine = array(
            'id' => $sampleSaleLineId,
            'product_id' => $productId,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $sampleSaleLineAssigned = array(
            'id' => $sampleSaleLineId,
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('assign a sale line to a sale order via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveInDatabase('salelines', $sampleSaleLine);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/salelines/'.$sampleSaleLineId.'/assign/'.$sampleSaleOrderId, []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('salelines', $sampleSaleLineAssigned);
    }

    public function AcknowledgeSaleLineTest(ApiTester $I) {
        $categoryId = '1';

        $productId = '1';

        $customerId = '1';

        $sampleCategory = array('id' => $categoryId, 'name' => 'category1', 'description' => 'a test category description for 1');

        $sampleProduct = array('id' => $productId, 'name' => 'product1', 'category_id' => $categoryId,
            'description' => 'a test product description for 1');

        $sampleCustomer = array('id' => $customerId, 'name' => 'customer1', 'description' => 'a test customer description for 1');

        $sampleSaleOrderId = '1';
        $sampleSaleOrder = array('id' => $sampleSaleOrderId, 'customer_id' => $customerId, 'state' => true, 'comments' => 'a test sale order comment');

        $sampleSaleLineId = '1';
        $sampleSaleLine = array(
            'id' => $sampleSaleLineId,
            'state' => true,
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );
        $sampleSaleLineAcknowledged = array(
            'id' => $sampleSaleLineId,
            'state' => false,
            'sale_order_id' => $sampleSaleOrderId,
            'product_id' => $productId,
            'units' => number_format(10, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $sampleStockBeforeSale = array(
            'product_id' => $productId,
            'quantity' => number_format(100, 2),
            'unit_price' => number_format(12.0, 2)
        );
        $sampleStockAfterSale = array(
            'product_id' => $productId,
            'quantity' => number_format(90, 2),
            'unit_price' => number_format(12.0, 2)
        );

        $I->wantTo('acknowledge a sale line to stock via API');
        $I->haveInDatabase('categories', $sampleCategory);
        $I->haveInDatabase('products', $sampleProduct);
        $I->haveInDatabase('customers', $sampleCustomer);
        $I->haveInDatabase('saleorders', $sampleSaleOrder);
        $I->haveInDatabase('salelines', $sampleSaleLine);
        $I->haveInDatabase('stocks', $sampleStockBeforeSale);
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendPOST('/salelines/'.$sampleSaleLineId.'/acknowledge', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('"errors":false');
        $I->seeInDatabase('salelines', $sampleSaleLineAcknowledged);
        $I->seeInDatabase('stocks', $sampleStockAfterSale);
    }
}
