<?php namespace Anymarket\Model;

class OrderModel 
{
	
	const ORDER_STATUS_CONCLUDED 				= 'CONCLUDED';
	const ORDER_STATUS_CANCELED 				= 'CANCELED';
	const ORDER_STATUS_INVOICED 				= 'INVOICED';
	const ORDER_STATUS_PAID_WAITING_DELIVERY 	= 'PAID_WAITING_DELIVERY';
	const ORDER_STATUS_PAID_WAITING_SHIP 		= 'PAID_WAITING_SHIP';
	const ORDER_STATUS_PENDING 					= 'PENDING';
	const ORDER_STATUS_FROZEN 					= 'FROZEN';

	public static function getStatusName($code) {
	    switch($code) {
	        case self::ORDER_STATUS_CONCLUDED:		             return 'Concluído';
	        case self::ORDER_STATUS_CANCELED:	                 return 'Cancelado';
	        case self::ORDER_STATUS_INVOICED:		             return 'Faturado';
	        case self::ORDER_STATUS_PAID_WAITING_DELIVERY:		 return 'Pago aguardando entrega';
	        case self::ORDER_STATUS_PAID_WAITING_SHIP:		     return 'Pago aguardando envio';
	        case self::ORDER_STATUS_PENDING:		             return 'Pendente';
	        case self::ORDER_STATUS_FROZEN:		                 return 'Congelado';
	    }
	    return null;
	}
	
	public $marketPlaceId;
	public $marketPlaceNumber;
	public $marketPlace;
	public $accountName;
	public $partnerId;
	public $createdAt;
	public $paymentDate;
	public $transmissionStatus;
	public $status;
	public $marketPlaceStatus;
	public $marketplaceStatusComplement;
	public $discount;
	public $freight;
	public $interestValue;
	public $gross;
	public $total;
	public $marketPlaceUrl;
	public $marketPlaceShipmentStatus;
	/** @var ShippingModel $shipping */
	public $shipping;
	/** @var BillingAddressModel $billingAddress */
	public $billingAddress;
	/** @var AnymarketAddressModel $anymarketAddress */
	public $anymarketAddress;
	/** @var BuyerModel $buyer */
	public $buyer;
	/** @var PaymentModel[] $payments */
	public $payments=array();
	/** @var ItemModel[] $items */
	public $items=array();
	public $deliverStatus;

}