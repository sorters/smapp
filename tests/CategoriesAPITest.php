<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesAPITest extends TestCase
{
    protected static $baseURL = '/api/v1';
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetGivesCategories()
    {
        $response = $this->call('GET', self::$baseURL.'/categories');
        $this->assertEquals(200, $response->status());
    }

    public function testCreatesCategory()
    {
        $this->post(self::$baseURL.'/categories',
                    ['name' => 'testCategory', 'description' => 'descriptive test description']
        )->seeJson(['errors' => false])
         ->ass;
    }
}
