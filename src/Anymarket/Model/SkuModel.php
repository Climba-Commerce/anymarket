<?php namespace Anymarket\Model;

class SkuModel 
{

	public $title;
	public $partnerId;
	public $ean;
	public $amount;
	public $price;
	public $additionalTime=0;
	/** @var VariationModel[] $variations */
	public $variations=array();

}