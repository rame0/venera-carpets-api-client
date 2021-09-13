<?php


use PHPUnit\Framework\TestCase;
use rame0\Venera\API\Client;


class ClientTest extends TestCase
{
    private ?Client $_client = null;
    /**
     * @var array|false
     */
    private $_ini_settings;

    private function test__construct()
    {
        $this->_ini_settings = parse_ini_file('config.ini', true, INI_SCANNER_TYPED);
        $this->_client = new Client($this->_ini_settings['token']);


        $this->assertNotEquals(null, $this->_client, "Can't create Client!");
    }

    public function testRequest()
    {
        $this->test__construct();

        $this->_client->request('h_shop_categories', ['page' => 1, 'b' => ['c', 'd', 'e']]);
    }
}
