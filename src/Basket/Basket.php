<?php
namespace AcmeWidgetCo\Basket;

use AcmeWidgetCo\Catalog\Catalog;
use AcmeWidgetCo\Delivery\DeliveryCost;
use AcmeWidgetCo\Offer\Offerings;

class Basket {
	private Catalog $catalog;
	private DeliveryCost $delivery;
	private Offerings $offers;
	private array $items;

	// todo add parameter types
	public function __construct(Catalog $catalog, DeliveryCost $delivery, Offerings $offers) {
		$this->catalog = $catalog;
		$this->delivery = $delivery;
		$this->offers = $offers;
	}

	public function addProduct($product_code): void {
		$product = $this->catalog->getProduct($product_code);
		if (is_null($product)) {
			throw new \Exception("Not a valid product code. Catalog contain a product with code: {$product_code}");
		}
		if (!isset($this->items[$product_code])) {
			$this->items[$product_code] = new Item($product);
		} else {
			$this->items[$product_code]->increaseQuantity();
		}
	}

	public function getTotal(): float {
		$total = 0.0;

		// calculate the raw sub-total
		foreach ($this->items as $item) {
			$total += $item->getProduct()->getPrice() * $item->getQuantity();
		}

		/**
		 * two approaches:
		 *   1. get only the applicable offers and then apply them
		 *   2. get all active offers, check if each one is applicable before applying it
		 */
		/**
		 * The following is pseudo-code, I need to finalize some decisions once
		 * I've thought about it more. I'd normally do this internally but
		 * thought I'd show this in the commit history as part of my thought
		 * process. Rather than just say "apply" all offers and internally only
		 * apply them when the conditions are met, I think if a UI is attached, 
		 * it'd be good to know if an offer is applicable so that we can notify
		 * users. It'll functionally be the same but I think it improves the
		 * UI/UX.
		 * todo finalize this code
		 */
		/*$offers = $this->offers->getApplicableOffers($this->items);
		if (!empty($this->offers)) {
			foreach ($offers as $offer) {
				$total -= $offer->apply(); // this is the offset approach
				// or
				$total = $offer->apply($total or $this->items); // this is the absolute/reset approach
			}
		}
		// or
		$offers = $this->offers->getActiveOffers();
		if (!empty($this->offers)) {
			foreach ($offers as $offer) {
				if ($offer->isApplicable()) {
					$total -= $offer->apply(); // this is the offset approach
					// or
					$total = $offer->apply($total or $this->items); // this is the absolute/reset approach
				}
			}
		}*/
		// apply special offers/deals/promotions
		$total -= $this->offers->applyOffers($this->items);

		// calculate delivery cost
		$total += $this->delivery->calculateDeliveryCost($total);

		// round to nearest monetary value (i.e. $0.01 is the smallest denomination of currency, at least for USD)
		// normally I'd use the default PHP_ROUND_HALF_UP but that caused tests to fail
		$total = round($total, 2, PHP_ROUND_HALF_DOWN);
		return $total;
	}
}