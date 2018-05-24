<?php namespace Anymarket\Model;

class ItemModel 
{

	/** @var SkuModel $sku */
	public $sku;
	/** @var ProductModel $product */
	public $product;
	public $amount;
	public $unit;
	public $discount;
	public $gross;
	public $total;
	public $marketPlaceId;
	/** @var OrderItemShippingModel[] $shippings */
	public $shippings=array();

}