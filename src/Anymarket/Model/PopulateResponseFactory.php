<?php 
namespace Anymarket\Model;

class PopulateResponseFactory
{
	
    public static function mapObjects(){
    
        $objects                        = array();
    
        return $objects;
    
    }
    
    /**
     * @return self
     */
    public static function genericPopulateResponseBody($model, $responseBody){
        
        $objectsMap = static::mapObjects();
    
        foreach ($responseBody as $key => $value){
            if (property_exists($model, $key)){
                if (isset($objectsMap[$key])){
    
                    $object = $objectsMap[$key];
                    if ($object['type'] == 'array'){
    
                        $model->{$key} = array();
    
                        foreach ($value as $arrayKey => $arrayValue){
                            $model->{$key}[] = $object['object']->populateResponseBody($arrayValue);
                        }
    
                    }
    
                }else{
                    $model->{$key} = $value;
                }
            }
        }
    
        return $model;
    
    }
    
}