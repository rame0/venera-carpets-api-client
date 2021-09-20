<?php

namespace rame0\Venera\API\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use rame0\Venera\API\Client;

/**
 *
 */
class ClientTest extends TestCase
{
    /**
     * @var Client|null
     */
    private ?Client $_client = null;
    /**
     * @var array|false
     */
    private $_ini_settings;

    /**
     * @covers Client::category
     * @uses   Client::_request
     * @throws Exception
     */
    public function testCategory()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->category(1));
    }

    /**
     * @covers \rame0\Venera\API\Client::__construct
     */
    private function test__construct()
    {
        $this->_ini_settings = parse_ini_file('config.ini', true, INI_SCANNER_TYPED);
        if (empty($this->_client)) {
            $this->_client = new Client($this->_ini_settings['token']);
            $this->assertNotEquals(null, $this->_client, "Can't create Client!");
        }
    }

    /**
     * @covers Client::categories
     * @throws Exception
     * @uses   Client::_request
     */
    public function testCategories()
    {
        $this->test__construct();


        $response = $this->_client->categories();
        $this->assertIsArray($response);

        $response = $this->_client->categories([], 100000);
        $this->assertEmpty($response);
    }


    /**
     * @covers Client::allCategories
     * @throws Exception
     * @uses   Client::_request
     */
    public function testAllCategories()
    {
        $this->test__construct();

        $this->assertIsArray($this->_client->allCategories());
    }

    /**
     * @covers Client::property
     * @uses   Client::_request
     * @throws Exception
     */
    public function testProperty()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->property(2));
    }

    /**
     * @covers Client::propertys
     * @uses   Client::_request
     * @throws Exception
     */
    public function testProperties()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->properties());
    }

    /**
     * @covers Client::property_value
     * @uses   Client::_request
     * @throws Exception
     */
    public function testProperty_value()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->property_value(10));
    }

    /**
     * @covers Client::property_values
     * @uses   Client::_request
     * @throws Exception
     */
    public function testProperty_values()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->property_values());
    }


    /**
     * @covers Client::brand
     * @uses   Client::_request
     * @throws Exception
     */
    public function testBrand()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->brand(1));
    }

    /**
     * @covers Client::brands
     * @uses   Client::_request
     * @throws Exception
     */
    public function testBrands()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->brands());
    }

    /**
     * @covers Client::price_value
     * @uses   Client::_request
     * @throws Exception
     */
    public function testPrice_value()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->price_value(1));
    }


    /**
     * @covers Client::property_values
     * @uses   Client::_request
     * @throws Exception
     */
    public function testPrice_values()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->price_values());
    }

    /**
     * @covers Client::product_warehouse
     * @uses   Client::_request
     * @throws Exception
     */
    public function testProduct_warehouse()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->product_warehouse(4));
    }

    /**
     * @covers Client::warehouses
     * @uses   Client::_request
     * @throws Exception
     */
    public function testProduct_warehouses()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->product_warehouses());
    }

    /**
     * @covers Client::product
     * @uses   Client::_request
     * @throws Exception
     */
    public function testProduct()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->product(1));
    }

    /**
     * @covers Client::products
     * @uses   Client::_request
     * @throws Exception
     */
    public function testProducts()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->products());
    }

    /**
     * @covers Client::warehouse
     * @uses   Client::_request
     * @throws Exception
     */
    public function testWarehouse()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->warehouse(4));
    }

    /**
     * @covers Client::warehouses
     * @uses   Client::_request
     * @throws Exception
     */
    public function testWarehouses()
    {
        $this->test__construct();
        $this->assertIsArray($this->_client->warehouses());
    }
}
