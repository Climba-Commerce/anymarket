<?php
namespace Anymarket;

use Anymarket\Model\StandardResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Throwable;
use function json_decode;

class Anymarket
{

    public $sandBoxMode=true;

    private $token;

    private $sandBoxUrl 	= 'http://sandbox-api.anymarket.com.br/v2/';
    private $productionUrl 	= 'http://api.anymarket.com.br/v2/';

    /**
     * @var ILogger
     */
    protected $logger;

    public function __construct($token)
    {
        $this->token     	= $token;
    }

    private function changeServerUrlToBackendUrl(): void
    {
        $this->sandBoxUrl = 'http://sandbox.anymarket.com.br/rest/api/';
        $this->productionUrl = 'https://app.anymarket.com.br/rest/api/';
    }

    /**
     * @return ILogger|null
     */
    public function getLogger(): ?ILogger
    {
        return $this->logger;
    }

    /**
     * @param ILogger|null $logger
     */
    public function setLogger(?ILogger $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param array $parameters
     * @return StandardResponse
     */
    public function getProducts($parameters=array()): StandardResponse
    {
        return $this->send('GET', "products", array(), $parameters);
    }

    /**
     * @param $productId
     * @param array $parameters
     * @return StandardResponse
     */
    public function getProductDetails($productId, $parameters=array()): StandardResponse
    {
        return $this->send('GET', "products/$productId", array(), $parameters);
    }

    /**
     * @param $productId
     * @param array $parameters
     * @return StandardResponse
     */
    public function getProductsSkus($productId, array $parameters=array()): StandardResponse
    {
        return $this->send('GET', "products/$productId/skus", array(), $parameters);
    }

    /**
     * @param array $parameters
     * @return StandardResponse
     */
    public function getStock(array $parameters=array()): StandardResponse
    {
        return $this->send('GET', "stocks", [], $parameters);
    }

    /**
     * @param $productId
     * @return StandardResponse
     */
    public function getProductsImages($productId): StandardResponse
    {
        return $this->send('GET', "products/$productId/images");
    }

    /**
     * @param $orderId
     * @return StandardResponse
     */
    public function getOrder($orderId): StandardResponse
    {
        return $this->send('GET', "orders/$orderId");
    }

    /**
     * @param array $parameters
     * @return StandardResponse
     */
    public function getCategories($parameters=array()): StandardResponse
    {
        return $this->send('GET', "categories", array(), $parameters);
    }

    /**
     * @param array $parameters
     * @return StandardResponse
     */
    public function getVariations($parameters=array()): StandardResponse
    {
        return $this->send('GET', "variations", array(), $parameters);
    }

    /**
     * @param array $parameters
     * @return StandardResponse
     */
    public function getBrands($parameters=array()): StandardResponse
    {
        return $this->send('GET', "brands", array(), $parameters);
    }

    /**
     * @return StandardResponse
     */
    public function getCategoriesFullPath(): StandardResponse
    {
        return $this->send('GET', "categories/fullPath");
    }

    /**
     * @param $id
     * @return StandardResponse
     */
    public function getCategory($id): StandardResponse
    {
        return $this->send('GET', "categories/$id");
    }

    /**
     * @param $typeId
     * @param array $getParameters
     * @return StandardResponse
     */
    public function getVariationValues($typeId, $getParameters=array()): StandardResponse
    {
        return $this->send('GET', "variations/$typeId/values", array(), $getParameters);
    }

    /**
     * @param $typeId
     * @param $valueId
     * @return StandardResponse
     */
    public function getVariationValue($typeId, $valueId): StandardResponse
    {
        return $this->send('GET', "variations/$typeId/values/$valueId");
    }

    /**
     * @param $id
     * @param $model
     * @return StandardResponse
     */
    public function putCategory($id, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('PUT', "categories/$id", $data);

    }

    /**
     * @param $id
     * @param $model
     * @return StandardResponse
     */
    public function putVariationType($id, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('PUT', "variations/$id", $data);

    }

    /**
     * @param $typeId
     * @param $valueId
     * @param $model
     * @return StandardResponse
     */
    public function putVariationValue($typeId, $valueId, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('PUT', "variations/$typeId/values/$valueId", $data);

    }

    /**
     * @param $id
     * @param $model
     * @return StandardResponse
     */
    public function putBrand($id, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('PUT', "brands/$id", $data);

    }

    /**
     * @param $id
     * @param $model
     * @return StandardResponse
     */
    public function putProduct($id, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('PUT', "products/$id", $data);

    }

    /**
     * @param $productId
     * @param $sku
     * @param $model
     * @return StandardResponse
     */
    public function putProductSku($productId, $sku, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('PUT', "products/$productId/skus/$sku", $data);

    }

    /**
     * @param $model
     * @return StandardResponse
     */
    public function postOrder($model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "orders", $data);

    }

    /**
     * @param $orderId
     * @param $model
     * @return StandardResponse
     */
    public function putOrder($orderId, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('PUT', "orders/$orderId", $data);

    }

    /**
     * @param $model
     * @return StandardResponse
     */
    public function putStock($model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('PUT', "stocks", $data);

    }

    /**
     * @param $orderId
     * @param $model
     * @return StandardResponse
     */
    public function putNfe($orderId, $model): StandardResponse
    {

        $data                       = array();
        $data['body']               = $model;

        $options                    = array();
        $options['Content-Type']    = 'application/xml';

        return $this->send('PUT', "orders/$orderId/nfe", $data, array(), $options);

    }

    /**
     * @param $id
     * @return StandardResponse
     */
    public function deleteCategory($id): StandardResponse
    {
        return $this->send('DELETE', "categories/$id");
    }

    /**
     * @param $model
     * @return StandardResponse
     */
    public function postCategory($model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "categories", $data);

    }

    /**
     * @param $model
     * @return StandardResponse
     */
    public function postVariationType($model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "variations", $data);

    }

    /**
     * @param $typeId
     * @param $model
     * @return StandardResponse
     */
    public function postVariationValue($typeId, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "variations/$typeId/values", $data);

    }

    /**
     * @param $model
     * @return StandardResponse
     */
    public function postBrand($model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "brands", $data);

    }

    /**
     * @param $model
     * @return StandardResponse
     */
    public function postProduct($model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "products", $data);

    }

    /**
     * @return StandardResponse
     */
    public function getCallbacks(): StandardResponse
    {

        $data           = array();

        return $this->send('GET', "callbacks", $data);

    }

    /**
     * @param $model
     * @return StandardResponse
     */
    public function postCallback($model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "callbacks", $data);

    }

    /**
     * @param $id
     * @return StandardResponse
     */
    public function deleteCallback($id): StandardResponse
    {

        return $this->send('DELETE', "callbacks/$id");

    }

    /**
     * @param $productId
     * @param $model
     * @return StandardResponse
     */
    public function postProductSku($productId, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "products/$productId/skus", $data);

    }

    /**
     * @param $productId
     * @param $model
     * @return StandardResponse
     */
    public function postProductImage($productId, $model): StandardResponse
    {

        $data           = array();
        $data['json']   = $this->populateJson($model);

        return $this->send('POST', "products/$productId/images", $data);

    }

    /**
     * @param $productId
     * @param $productImageId
     * @return StandardResponse
     */
    public function deleteProductImage($productId, $productImageId): StandardResponse
    {

        return $this->send('DELETE', "products/$productId/images/$productImageId");

    }

    /**
     * @param $typeId
     * @return StandardResponse
     */
    public function deleteVariationType($typeId): StandardResponse
    {

        return $this->send('DELETE', "variations/$typeId");

    }

    /**
     * @param $brandId
     * @return StandardResponse
     */
    public function deleteBrand($brandId): StandardResponse
    {

        return $this->send('DELETE', "brands/$brandId");

    }

    /**
     * @param $productId
     * @return StandardResponse
     */
    public function deleteProduct($productId): StandardResponse
    {

        $this->changeServerUrlToBackendUrl();
        return $this->send('DELETE', "products/$productId");

    }

    /**
     * @param $typeId
     * @param $valueId
     * @return StandardResponse
     */
    public function deleteVariationValue($typeId, $valueId): StandardResponse
    {

        return $this->send('DELETE', "variations/$typeId/values/$valueId");

    }

    /**
     * Faz a população do json de acordo com os dados fornecidos para cada tipo de requisição
     * @param $objeto
     * @return mixed
     */
    private function populateJson($objeto){
        return $objeto;
    }


    /**
     * @return string
     */
    private function generateBaseUrl(): string
    {
        if ($this->sandBoxMode){
            return $this->sandBoxUrl;
        }
        return $this->productionUrl;
    }

    /**
     * @param $options
     * @return array
     */
    private function getRequestHeaders(array $options): array
    {
        $requestHeaders                 = array();
        $requestHeaders['Accept']       = 'application/json';
        $requestHeaders['gumgaToken']   = $this->token;

        $requestHeaders = array_merge($requestHeaders, $options);

        return $requestHeaders;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $getParameters
     * @param array $optionsRequest
     * @return StandardResponse
     */
    private function send(string $method, string $url, $data=array(), $getParameters=array(), $optionsRequest=array()): StandardResponse
    {

        try {

            if ($getParameters){

                $params = array();
                foreach ($getParameters as $filterName => $filterValue){
                    $params[] = $filterName.'='.$filterValue;
                }

                $url.= '?'.implode('&', $params);

            }

            $requestHeaders = $this->getRequestHeaders($optionsRequest);
            $data['headers'] = $requestHeaders;

            $clientParams 						= array();
            $clientParams['base_uri'] 			= $this->generateBaseUrl();
            $clientParams['exceptions'] 		= false;

            if ($this->getLogger()) {
                $this->getLogger()->request(
                    $clientParams['base_uri'].$url,
                    $method,
                    $requestHeaders,
                    $data['json'] ?? null
                );
            }

            $client = new Client($clientParams);

            $response = $client->request($method, $url, $data);

            if ($this->getLogger()) {
                $this->getLogger()->response(
                    $response->getStatusCode(),
                    $response->getHeaders(),
                    (string)$response->getBody()
                );
            }

            $standardResponse = $this->generateStandardResponse($response);

        } catch (Throwable $e) {

            $mensagem = [];
            $mensagem['message'] = $e->getMessage();

            $standardResponse                   = new StandardResponse();
            $standardResponse->statusCode       = $e->getCode();
            $standardResponse->responseBody     = $mensagem;

        }

        return $standardResponse;

    }

    /**
     * @param Response $response
     * @return StandardResponse
     */
    private function generateStandardResponse(Response $response): StandardResponse
    {

        $standardResponse                   = new StandardResponse();
        $standardResponse->statusCode       = $response->getStatusCode();
        $standardResponse->responseBody     = json_decode($response->getBody(), true);

        return $standardResponse;

    }

}
