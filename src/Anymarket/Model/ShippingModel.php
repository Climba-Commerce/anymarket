<?php namespace Anymarket\Model;

class ShippingModel 
{
    
    const SHIPPING_TYPE_PAC         = 'PAC';
    const SHIPPING_TYPE_SEDEX       = 'SEDEX';

	public $city;
	public $state;
	public $stateNameNormalized;
	public $address;
	public $number;
	public $neighborhood;
	public $country;
	public $street;
	public $comment;
	public $zipCode;
	public $receiverName;
	public $promisedShippingTime;

}