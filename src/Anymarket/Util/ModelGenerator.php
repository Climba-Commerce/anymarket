<?php
namespace Anymarket\Util;

class ModelGenerator
{
    
    public function generateModels(){
    	
    	$string = '{
  "marketPlaceId": "string",
  "marketPlaceNumber": "string",
  "marketPlace": "B2W",
  "accountName": "string",
  "partnerId": "string",
  "createdAt": "2018-05-22T10:45:12Z",
  "paymentDate": "2018-05-22T10:45:12Z",
  "transmissionStatus": "string",
  "status": "string",
  "marketPlaceStatus": "string",
  "marketplaceStatusComplement": "string",
  "discount": 0,
  "freight": 0,
  "interestValue": 0,
  "gross": 0,
  "total": 0,
  "marketPlaceUrl": "string",
  "marketPlaceShipmentStatus": "string",
  "shipping": {
    "city": "string",
    "state": "string",
    "stateNameNormalized": "string",
    "address": "string",
    "number": "string",
    "neighborhood": "string",
    "country": "string",
    "street": "string",
    "comment": "string",
    "zipCode": "string",
    "receiverName": "string",
    "promisedShippingTime": "2018-05-22T10:45:12Z"
  },
  "billingAddress": {
    "city": "string",
    "state": "string",
    "stateNameNormalized": "string",
    "country": "string",
    "street": "string",
    "number": "string",
    "neighborhood": "string",
    "comment": "string",
    "zipCode": "string"
  },
  "anymarketAddress": {
    "state": "string",
    "city": "string",
    "zipCode": "string",
    "neighborhood": "string",
    "address": "string",
    "street": "string",
    "number": "string",
    "comment": "string",
    "receiverName": "string",
    "promisedShippingTime": "string"
  },
  "buyer": {
    "marketPlaceId": "string",
    "name": "string",
    "documentType": "string",
    "document": "string",
    "email": "string",
    "phone": "string",
    "cellPhone": "string",
    "documentNumberNormalized": "string"
  },
  "payments": [
    {
      "method": "string",
      "status": "string",
      "value": 0,
      "installments": 0,
      "marketplaceId": "string",
      "paymentMethodNormalized": "string",
      "paymentDetailNormalized": "string"
    }
  ],
  "items": [
    {
      "sku": {
        "title": "string",
        "partnerId": "string"
      },
      "product": {
        "title": "string"
      },
      "amount": 0,
      "unit": 0,
      "discount": 0,
      "gross": 0,
      "total": 0,
      "marketPlaceId": "string",
      "shippings": [
        {
          "shippingtype": "string",
          "shippingCarrierNormalized": "string",
          "shippingCarrierTypeNormalized": "string"
        }
      ]
    }
  ],
  "deliverStatus": "string"
}';
    	
    	$object = \json_decode($string);
    	
//     	echo "<textarea style='width: 100%;' rows='50'>";
    	$models = $this->generateModel('standardClass', $object);
    	foreach ($models as $modelName => $model){
	    	file_put_contents(__DIR__."\\..\Model\\".$modelName.".php", $model);
    	}
//     	echo "</textarea>";
    	exit();
    	
    }
    	
    public function generateModel($className, $data, $generatedModels = array()){
    	
    	$className = static::mb_ucfirst($className).'Model';
    	
    	$nameSpace = __NAMESPACE__;
    	$nameSpace = explode('\\', $nameSpace);
    	$nameSpace = reset($nameSpace);
    	$nameSpace = $nameSpace.'\\Model';
    	
    	$model = "<?php namespace $nameSpace;\n\n";
    	
    	$model.= "class $className \n{\n";
    	
    	foreach ($data as $attributeName => $values){
    		
    		$model.= "\n\t";
    		
			if (is_object($values)){
				$classAttributeName = static::mb_ucfirst($attributeName);
				$model.= "/** @var {$classAttributeName}Model \${$attributeName} */\n\t";
				$generatedModels = array_merge($generatedModels, self::generateModel($attributeName, $values));
			}
			if (is_array($values)){
				$primeiroObjeto = reset($values);
				$classAttributeName = static::mb_ucfirst($attributeName);
				$model.= "/** @var {$classAttributeName}Model[] \${$attributeName} */\n\t";
				$generatedModels = array_merge($generatedModels, self::generateModel($attributeName, $primeiroObjeto));
			}
			
			$model.= "public \$$attributeName";
			
			if (is_array($values)){
				$model.= "=array()";
			}
			
			$model.= ";";
    		
    	}
    	
    	$model.= "\n\n}";
    	
    	$generatedModels[$className] = $model;
    	
    	return $generatedModels;
    	
    }
    
    private function mb_ucfirst($str) {
    	$fc = mb_strtoupper(mb_substr($str, 0, 1));
    	return $fc.mb_substr($str, 1);
    }
    
}
