<?php namespace Anymarket\Model;

class ProductModel 
{

	public $title;
	public $description;
	/** @var CategoryModel $category */
	public $category;
	/** @var BrandModel $brand */
	public $brand;
	/** @var NbmModel $nbm */
	public $nbm;
	/** @var OriginModel $origin */
	public $origin;
	public $model;
	public $videoUrl;
	public $gender='';
	public $warrantyTime;
	public $warrantyText='';
	public $height;
	public $width;
	public $weight;
	public $length;
	public $priceFactor;
	public $calculatedPrice;
	public $definitionPriceScope;
	/** @var CharacteristicModel[] $characteristics */
	public $characteristics=array();
	/** @var ImageModel[] $images */
	public $images=array();
	/** @var SkuModel[] $skus */
	public $skus=array();
	public $allowAutomaticSkuMarketplaceCreation=true;

}