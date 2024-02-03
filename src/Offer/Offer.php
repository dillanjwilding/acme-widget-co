<?php
namespace AcmeWidgetCo\Offer;

use AcmeWidgetCo\Basket\Item;

/**
 * Ok, I may be overthinking this but typically there are a couple parts to a
 * deal/promotion/offer; usually they are boundaries such as dates in which it
 * is valid, the condition that needs to be met (date, order amount, buying 2
 * of a particular item, etc), and the discount. I guess there's also the
 * ability to activate or deactivate offers if need be but they could always
 * just set the end date to yesterday to deactivate an offer.
 */
abstract class Offer implements OfferInterface {
	// todo add start date and end date
	// todo add id, display id/code, and name
	protected string | null $offer_product;
	protected string | null $discounted_product;
	protected float $discount_rate;

	// should probably put $discount_rate first as it's not optional
	// I only made $offer_product and $discounted_product optional to support
	// more generic offers that don't require a specific product
	// like buy one get one free where it could be any product
	public function __construct(float $discount_rate, ?string $offer_product = null, ?string $discounted_product = null) {
		// probably could do data validation to verify products are valid
		$this->offer_product = $offer_product;
		$this->discounted_product = $discounted_product;
		$this->discount_rate = $discount_rate;
	}

	/**
	 * @param array<string, Item> $items
	 */
	public function isValid(array $items): bool {
		// todo check generic deal validation
		//   - today is between start and end dates
		//   - etc
		return true;
	}
}