<?php


class TagsCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function GetProductsByTagTest(ApiTester $I)
    {

        $sampleProducts = array(
            array('id' => '1', 'name' => 'product1', 'description' => 'a test product description for 1'),
            array('id' => '2', 'name' => 'product2', 'description' => 'a test product description for 2'),
            array('id' => '3', 'name' => 'product3', 'description' => 'a test product description for 3'),
        );

        $sampleTagId = '1';
        $sampleTag = array('id' => $sampleTagId, 'name' => 'tagname');

        $I->wantTo('get the products by a tag via API');
        $I->haveInDatabase('tags', $sampleTag);
        foreach($sampleProducts as $sampleProduct) {
            $I->haveInDatabase('products', $sampleProduct);
            $I->haveInDatabase('product_tag', array('tag_id' => $sampleTag['id'], 'product_id' => $sampleProduct['id']));
        }
        $I->haveHttpHeader('Authorization', 'Bearer IsZs01MiurjFPmCHuXG9b2dO7oSOgn14ZbsYtpDANfrYuVvglgX61cq2b6sY');
        $I->sendGET('/tags/'.$sampleTagId.'/products');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array("errors" => false, "products" => $sampleProducts));

    }
}
