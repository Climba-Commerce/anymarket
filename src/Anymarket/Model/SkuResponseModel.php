<?php namespace Anymarket\Model;

class SkuResponseModel 
{

	public $id;
	public $title;
	public $partnerId;
	public $ean;
	public $amount;
	public $additionalTime;
	public $price;
	public $sellPrice;
	/** @var VariationModel[] $variations */
	public $variations=array();

}