<?php
namespace Anymarket;

use Anymarket\Model\StandardResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class Anymarket
{
    
	public $sandBoxMode=true;
	
	private $token;
	
    private $sandBoxUrl 	= 'http://sandbox-api.anymarket.com.br/v2/';
    private $productionUrl 	= 'http://api.anymarket.com.br/v2/';
    
    /**
     * Se definido, irá salvar todos os logs de requisição/resposta passados pela biblioteca
     * @example nome_pasta/2018/04/30/anymarket.log
     * @var string $logsName
     */
    private $logsName;
    
    protected $logger;
    
    public function __construct($token, $logsName=false){
        $this->token     	= $token;
        $this->logsName     = $logsName;
    }
    
    public function getProducts($parameters=array()){
    	return $this->send('GET', "products", array(), $parameters);
    }
    
    public function getProductDetails($productId, $parameters=array()){
    	return $this->send('GET', "products/$productId", array(), $parameters);
    }
    
    public function getProductsSkus($productId, $parameters=array()){
    	return $this->send('GET', "products/$productId/skus", array(), $parameters);
    }
    
    public function getProductsImages($productId){
    	return $this->send('GET', "products/$productId/images");
    }
    
    public function getOrder($orderId){
    	return $this->send('GET', "orders/$orderId");
    }
    
    public function getCategories($parameters=array()){
    	return $this->send('GET', "categories", array(), $parameters);
    }
    
    public function getVariations($parameters=array()){
    	return $this->send('GET', "variations", array(), $parameters);
    }
    
    public function getBrands($parameters=array()){
    	return $this->send('GET', "brands", array(), $parameters);
    }
    
    public function getCategoriesFullPath(){
    	return $this->send('GET', "categories/fullPath");
    }
    
    public function getCategory($id){
    	return $this->send('GET', "categories/$id");
    }
    
    public function getVariationValues($typeId, $getParameters=array()){
    	return $this->send('GET', "variations/$typeId/values", array(), $getParameters);
    }
    
    public function getVariationValue($typeId, $valueId){
    	return $this->send('GET', "variations/$typeId/values/$valueId");
    }
    
    public function putCategory($id, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('PUT', "categories/$id", $data);
    	
    }
    
    public function putVariationType($id, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('PUT', "variations/$id", $data);
    	
    }
    
    public function putVariationValue($typeId, $valueId, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('PUT', "variations/$typeId/values/$valueId", $data);
    	
    }
    
    public function putBrand($id, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('PUT', "brands/$id", $data);
    	
    }
    
    public function putProduct($id, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('PUT', "products/$id", $data);
    	
    }
    
    public function putProductSku($productId, $sku, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('PUT', "products/$productId/skus/$sku", $data);
    	
    }
    
    public function putOrder($orderId, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('PUT', "orders/$orderId", $data);
    	
    }
    
    public function putStock($model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('PUT', "stocks", $data);
    	
    }
    
    public function deleteCategory($id){
    	return $this->send('DELETE', "categories/$id");
    }
    
    public function postCategory($model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('POST', "categories", $data);
    	
    }
    
    public function postVariationType($model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('POST', "variations", $data);
    	
    }
    
    public function postVariationValue($typeId, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('POST', "variations/$typeId/values", $data);
    	
    }
    
    public function postBrand($model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('POST', "brands", $data);
    	
    }
    
    public function postProduct($model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('POST', "products", $data);
    	
    }
    
    public function postProductSku($productId, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('POST', "products/$productId/skus", $data);
    	
    }
    
    public function postProductImage($productId, $model){
    	
    	$data           = array();
    	$data['json']   = $this->populateJson($model);
    	
    	return $this->send('POST', "products/$productId/images", $data);
    	
    }
    
    public function deleteProductImage($productId, $productImageId){
    	
    	return $this->send('DELETE', "products/$productId/images/$productImageId");
    	
    }
    
    public function deleteVariationValue($typeId, $valueId){
    	
    	return $this->send('DELETE', "variations/$typeId/values/$valueId");
    	
    }
    
    /**
     * Faz a população do json de acordo com os dados fornecidos para cada tipo de requisição
     */
    private function populateJson($objeto){
    	return $objeto;
    }
    
    private function getLogger() {
    	if (!$this->logger) {
    		$this->logger = with(new \Monolog\Logger('Anymarket'))->pushHandler(
				new \Monolog\Handler\RotatingFileHandler($this->logsName)
			);
    	}
    
    	return $this->logger;
    	
    }
    

    private function createGuzzleLoggingMiddleware($messageFormat) {
    	return \GuzzleHttp\Middleware::log(
    			$this->getLogger(),
    			new \GuzzleHttp\MessageFormatter($messageFormat)
    			);
    }
    
    private function createLoggingHandlerStack(array $messageFormats) {
    	
    	$stack = \GuzzleHttp\HandlerStack::create();
    
    	collect($messageFormats)->each(function ($messageFormat) use ($stack) {
    		$stack->unshift(
				$this->createGuzzleLoggingMiddleware($messageFormat)
			);
    	});
    	
		return $stack;
		
    }
    
    private function generateBaseUrl(){
    	if ($this->sandBoxMode){
    		return $this->sandBoxUrl;
    	}
    	return $this->productionUrl;
    }
    
    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @return StandardResponse|boolean
     */
    private function send($method, $url, $data=array(), $getParameters=array()){
        
        try {
        	
        	if ($getParameters){
        		
        		$params = array();
        		foreach ($getParameters as $filterName => $filterValue){
        			$params[] = $filterName.'='.$filterValue;
        		}
        		
        		$url.= '?'.implode('&', $params);
        		
        	}
        	
            $data['headers']['Accept'] 			= 'application/json';
            $data['headers']['gumgaToken'] 		= $this->token;
            
            $clientParams 						= array();
            $clientParams['base_uri'] 			= $this->generateBaseUrl();
            $clientParams['exceptions'] 		= false;
            
            if ($this->logsName){
	            $clientParams['handler'] 		= $this->createLoggingHandlerStack(['{method} {uri} HTTP/{version} {req_body}', 'Resposta: {code} - {res_body}']);
            }
            
            $client = new Client($clientParams);
            
            $response = $client->request($method, $url, $data);
            
            return $this->generateStandardResponse($response);
            
        } catch (\Exception $e) {
            return false;
        }
        
    }
    
    /**
     * @param Response $response
     * @return \Iugu\Model\StandardResponse
     */
    private function generateStandardResponse(Response $response){
        
        $standardResponse                   = new StandardResponse();
        $standardResponse->statusCode       = $response->getStatusCode();
        $standardResponse->responseBody     = \json_decode($response->getBody(), true);
        
        return $standardResponse;
        
    }
	
}
