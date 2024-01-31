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
	// todo $deliveryType should be optional
	public static function create(Catalog $catalog, string $deliveryType = 'standard'): Basket {
		// todo load/lookup $charge_rules and $offers
		$deliveryCost = new DeliveryCost($deliveryType);
		$offerService = new OfferService();
		/**
		 * I need to connect these concepts:
		 *  - While it "works" because $delivery is an object with a calculate
		 * function but to build a real world applicable solution that scales,
		 * I think I need an abstraction to differentiate different types of
		 * charge rules
		 *  - I haven't handled implementing Offer yet. Conceptually I need to
		 * determine if an offer is appropriate/applicable, then apply it but
		 * again, it'd be nice to have more structure facilitating 
		 * deals/promotions.
		 */
		return new Basket($catalog, $deliveryCost, $offerService);
	}
}