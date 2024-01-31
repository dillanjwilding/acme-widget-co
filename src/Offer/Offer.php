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
class Offer {
	// todo add start date and end date
	// todo add id, display id/code, and name
	private string | null $offer_product;
	//private int $offer_product_quantity = 1;
	private string | null $discounted_product;
	//private int $discounted_product_quantity = 1;
	private float $discount_rate;

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
		$product_codes = array_keys($items);
		// todo also need to check quantities
		if (!empty($this->offer_product) && !empty($this->discounted_product)) {
			if ($this->offer_product === $this->discounted_product) {
				return isset($items[$this->offer_product])
					&& $items[$this->offer_product]->getQuantity() >= 2; // $this->offer_product_quantity + $this->discounted_product_quantity
			} else {
				return isset($items[$this->offer_product]) 
					&& $items[$this->offer_product]->getQuantity() >= 1 // $this->offer_product_quantity
					&& isset($items[$this->discounted_product])
					&& $items[$this->discounted_product]->getQuantity() >= 1; // $this->discounted_product_quantity
			}
		}
		// todo add other conditions to support other offers
		//  - e.g. generic buy one get one (any product), discount_rate is applied to the product of lesser value
		return false;
	}

	/**
	 * @param array<string, Item> $items
	 */
	public function calculateDiscount(array $items): float {
		$item = $items[$this->discounted_product];
		$discount = floor($item->getQuantity() / 2) * $item->getProduct()->getPrice() * $this->discount_rate;
		return $discount;
	}
}