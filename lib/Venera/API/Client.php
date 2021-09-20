<?php

namespace rame0\Venera\API;

use Exception;

/**
 *
 */
class Client
{
    /**
     * @var string
     */
    private string $_token;
    /**
     * @var string
     */
    private string $_api_url;
    /**
     * @var string|null
     */
    private ?string $_cache_storage_path;

    /**
     * @param string      $token
     * @param string|null $cache_storage_path
     * @param string      $api_url
     */
    public function __construct(
        string  $token,
        ?string $cache_storage_path = null,
        string  $api_url = "https://api.venera-carpet.ru/api/"
    )
    {
        $this->_token = $token;
        $this->_api_url = $api_url;
        $this->_cache_storage_path = $cache_storage_path;
    }


    /**
     * @param array $parentId
     * @return array<array{"id": int, "parentId": int, "title": string, "slug": string}>
     * @throws Exception
     */
    public function allCategories(array $parentId = []): array
    {
        $page = 1;
        $categories = [];
        do {
            $response = $this->categories($parentId, $page);
            $categories = array_merge($categories, $response);
            $page++;
        } while (!empty($response));

        return $categories;
    }

    /**
     * Производители/коллекции (HShopCategory)
     *
     * Это справочник категорий сайта - Категории сайта могут быть вложенными. В случае Венеры, это
     * производитель/коллекция
     *      - id        integer    Уникальной идентификатор сущности
     *      - title     string     Название производителя
     *      - slug      string     Уникальная строка, сделанная из title с помощью транслитерации
     *      - parentId  integer    ИД родительской категории
     *
     * @param int $id
     * @return array{"id": int, "parentId": int, "title": string, "slug": string}
     * @throws Exception
     */
    public function category(int $id): array
    {
        return $this->_request('categories/' . $id);
    }

    /**
     * @param array $parentId
     * @param int   $page
     * @return array<array{"id": int, "parentId": int, "title": string, "slug": string}>
     * @throws Exception
     */
    public function categories(array $parentId = [], int $page = 1): array
    {
        $params = ['page' => $page];
        $params['parentId'] = $this->_checkGetArrayValue($parentId);

        return $this->_request('categories', $params);
    }

    /**
     * @param int $page
     * @return array<array{"id": int,"title": string,slug: string}>
     * @throws Exception
     */
    public function brands(int $page = 1): array
    {
        $params = ['page' => $page];
        return $this->_request('brands', $params);
    }

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function brand(int $id): array
    {
        return $this->_request('brands/' . $id);
    }

    /**
     * @param array $brandId
     * @param array $countryId
     * @param int   $page
     * @return array<array{"brandId":int,"countryId":int,"collectionId":int,"priceMeter":int,"priceMeterOld":int,"priceSaleMeter":int,"priceSalePercent":int,"comment":string}>
     * @throws Exception
     */
    public function price_values(array $brandId = [], array $countryId = [], int $page = 1): array
    {
        $params = [
            'page' => $page,
            'brandId' => $this->_checkGetArrayValue($brandId),
            'countryId' => $this->_checkGetArrayValue($countryId),
        ];

        return $this->_request('price_values', $params);
    }

    /**
     * @param int $id
     * @return array{"brandId":int,"countryId":int,"collectionId":int,"priceMeter":int,"priceMeterOld":int,"priceSaleMeter":int,"priceSalePercent":int,"comment":string}
     * @throws Exception
     */
    public function price_value(int $id): array
    {
        return $this->_request('price_values/' . $id);
    }

    /**
     * @param array $warehouse
     * @param array $warehouseId
     * @param array $productId
     * @param int   $page
     * @return array<array{"warehouse":int,"warehouseId":int,"productId":int}>
     * @throws Exception
     */
    public function product_warehouses(array $warehouse = [], array $warehouseId = [], array $productId = [], int $page = 1): array
    {
        $params = [
            'page' => $page,
            'warehouse' => $this->_checkGetArrayValue($warehouse),
            'warehouseId' => $this->_checkGetArrayValue($warehouseId),
            'productId' => $this->_checkGetArrayValue($productId),
        ];
        return $this->_request('product_warehouses', $params);
    }

    /**
     * @param int $id
     * @return array{"warehouse":int,"warehouseId":int,"productId":int}
     * @throws Exception
     */
    public function product_warehouse(int $id): array
    {
        return $this->_request('product_warehouses/' . $id);
    }

    /**
     * @param array $brandId
     * @param array $categoryId
     * @param array $parentId
     * @param array $tFormId
     * @param int   $page
     * @return array<array{"id": int,"parentId":
     *                           int,"brandId":int,"categoryId":int,"title":string,"articul":string,"content":string,"image":string,"image2":string,"image3":string,"image4":string,"image5":string,"tCollectionId":int,"tFormId":int,"tColorId":int,"tDisignId":int,"tCountryId":int,"tSizeId":int,"tQualityId":int,"tConsistId":int,"tDensityId":int,"tWeightId":int,"tPileHeightId":int,"tColor2Id":int,"tConsist2Id":int,"tDisign2Id":int,"tWidth":
     *                           "0.00","tHeight": "0.00","tWeight2Id": "0.000","tCapacityId":
     *                           "0.000000","synchroCode":string,"synchroPhoto":string,"yan13":string,"slug":string,"brand":
     *                           {"id":int,"title":string,"slug":string},"category":
     *                           {"id":int,"parentId":int,"title":string,"slug":string},"tCollection":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tForm":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tColor":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tDisign":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tCountry":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tSize":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tQuality":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tConsist":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tDensity":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tWeight":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tPileHeight":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tColor2":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tConsist2":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"tDisign2":
     *                           {"id":int,"propertyId":int,"valueVarchar":string},"values":
     *                           [{"id":int,"propertyId":int,"valueVarchar":string}]}>
     * @throws Exception
     */
    public function products(array $brandId = [], array $categoryId = [], array $parentId = [], array $tFormId = [], int $page = 1): array
    {
        $params = [
            'page' => $page,
            '$brandId' => $this->_checkGetArrayValue($brandId),
            '$categoryId' => $this->_checkGetArrayValue($categoryId),
            '$parentId' => $this->_checkGetArrayValue($parentId),
            '$tFormId' => $this->_checkGetArrayValue($tFormId),
        ];
        return $this->_request('products', $params);
    }

    /**
     * @param int $id
     * @return array{"id": int,"parentId":
     *                     int,"brandId":int,"categoryId":int,"title":string,"articul":string,"content":string,"image":string,"image2":string,"image3":string,"image4":string,"image5":string,"tCollectionId":int,"tFormId":int,"tColorId":int,"tDisignId":int,"tCountryId":int,"tSizeId":int,"tQualityId":int,"tConsistId":int,"tDensityId":int,"tWeightId":int,"tPileHeightId":int,"tColor2Id":int,"tConsist2Id":int,"tDisign2Id":int,"tWidth":
     *                     "0.00","tHeight": "0.00","tWeight2Id": "0.000","tCapacityId":
     *                     "0.000000","synchroCode":string,"synchroPhoto":string,"yan13":string,"slug":string,"brand":
     *                     {"id":int,"title":string,"slug":string},"category":
     *                     {"id":int,"parentId":int,"title":string,"slug":string},"tCollection":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tForm":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tColor":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tDisign":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tCountry":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tSize":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tQuality":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tConsist":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tDensity":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tWeight":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tPileHeight":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tColor2":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tConsist2":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"tDisign2":
     *                     {"id":int,"propertyId":int,"valueVarchar":string},"values":
     *                     [{"id":int,"propertyId":int,"valueVarchar":string}]}
     * @throws Exception
     */
    public function product(int $id): array
    {
        return $this->_request('products/' . $id);
    }

    /**
     * @param int $page
     * @return array<array{"id":int,"title":string,"slug":string}>
     * @throws Exception
     */
    public function properties(int $page = 1): array
    {
        $params = ['page' => $page,];
        return $this->_request('properties', $params);
    }

    /**
     * @param int $id
     * @return array{"id":int,"title":string,"slug":string}
     * @throws Exception
     */
    public function property(int $id): array
    {
        return $this->_request('properties/' . $id);
    }

    /**
     * @param array $propertyId
     * @param int   $page
     * @return array<array{"id":int,"propertyId":int,"valueVarchar":string}>
     * @throws Exception
     */
    public function property_values(array $propertyId = [], int $page = 1): array
    {
        $params = [
            'page' => $page,
            '$propertyId' => $this->_checkGetArrayValue($propertyId),
        ];
        return $this->_request('property_values', $params);
    }

    /**
     * @param int $id
     * @return array{"id":int,"propertyId":int,"valueVarchar":string}
     * @throws Exception
     */
    public function property_value(int $id): array
    {
        return $this->_request('property_values/' . $id);
    }

    /**
     * @param int $page
     * @return array<array{"id":int,"title":string,"shortTitle":string}>
     * @throws Exception
     */
    public function warehouses(int $page = 1): array
    {
        $params = [
            'page' => $page,
        ];
        return $this->_request('warehouses', $params);
    }

    /**
     * @param int $id
     * @return array{"id":int,"title":string,"shortTitle":string}
     * @throws Exception
     */
    public function warehouse(int $id): array
    {
        return $this->_request('warehouses/' . $id);
    }


    /**
     * @param string $method
     * @param array  $params
     * @return array
     * @throws Exception
     */
    private function _request(string $method, array $params = []): array
    {
        $params['token'] = $this->_token;

        $query_string = http_build_query($params);

        $url = $this->_api_url . 'h_shop_' . $method . '?' . $query_string;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $head = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if (empty($head)) {
            throw new Exception("Curl request returned empty head!");
        }

        $response = json_decode($head, true);


        if ($httpCode != 200) {
            if ($response) {
                throw new Exception("$response->title $response->message");
            } else {
                throw new Exception("Unknown response!");
            }
        }

        if (empty($response)) {
            return [];
        }

        return $response;
    }

    /**
     * @param array $param
     * @return array|mixed
     */
    private function _checkGetArrayValue(array $param)
    {
        if (count($param) > 1) {
            return $param;
        } elseif (!empty($param)) {
            return $param[0];
        }

        return [];
    }

}