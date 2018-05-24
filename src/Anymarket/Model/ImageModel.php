<?php namespace Anymarket\Model;

class ImageModel 
{
	
	const STATUS_PROCESSED 		= 'PROCESSED';
	const STATUS_UNPROCESSED 	= 'UNPROCESSED';
	const STATUS_ERROR			= 'ERROR';

	public $index;
	public $main;
	public $url;
	public $variation;

}