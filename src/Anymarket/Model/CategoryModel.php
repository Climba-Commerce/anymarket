<?php namespace Anymarket\Model;

class CategoryModel 
{

	public $id;
	public $name;
	public $partnerId;
	/** @var CategoryParentModel $parent */
	public $parent;
	public $priceFactor;
	public $calculatedPrice;
	public $definitionPriceScope;

}