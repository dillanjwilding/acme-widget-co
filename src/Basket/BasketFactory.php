<?php
namespace AcmeWidgetCo\Basket;

use AcmeWidgetCo\Catalog\Catalog;
use AcmeWidgetCo\Delivery\DeliveryCost;
use AcmeWidgetCo\Offer\OfferService;

/**
 * Convenience Factory class so that instantiating Basket objects don't need to
 * handle looking up Delivery (Calculator?) and Offer (Offers?) to minimize
 * redundant code. 
 */
class BasketFactory {
	public static function create(Catalog $catalog, string $deliveryType = 'standard'): Basket {
		$deliveryCost = new DeliveryCost($deliveryType);
		$offerService = new OfferService();
		return new Basket($catalog, $deliveryCost, $offerService);
	}
}