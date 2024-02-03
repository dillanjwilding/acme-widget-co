<?php
namespace AcmeWidgetCo\Offer;

use AcmeWidgetCo\Basket\Item;

/**
 * This was a late addition. I had an epiphany and realized I was limiting
 * the offers to "buy one, get one" type deals when they could be almost anything.
 */
interface OfferInterface {
	// added constructor to be verbose but I think it could be removed because it may limit extensibility,
	//  now this is true, but it may not always when more types of offers are created
	public function __construct(float $discount_rate, ?string $offer_product = null, ?string $discounted_product = null);

	/**
	 * @param array<string, Item> $items
	 */
	public function isValid(array $items): bool;

	/**
	 * @param array<string, Item> $items
	 */
	public function calculateDiscount(array $items): float;
}