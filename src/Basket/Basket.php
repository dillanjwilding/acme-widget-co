<?php
namespace AcmeWidgetCo\Basket;

use AcmeWidgetCo\Catalog\Catalog;
use AcmeWidgetCo\Delivery\DeliveryCost;
use AcmeWidgetCo\Offer\OfferService;

class Basket {
	private Catalog $catalog;
	private DeliveryCost $deliveryCost;
	private OfferService $offerService;
	/** @var array<string, Item> */
	private array $items;

	public function __construct(Catalog $catalog, DeliveryCost $deliveryCost, OfferService $offerService) {
		$this->catalog = $catalog;
		$this->deliveryCost = $deliveryCost;
		$this->offerService = $offerService;
	}

	public function addProduct(string $product_code): void {
		$product = $this->catalog->getProduct($product_code);
		// could default quantity to 0 and always increase it by 1 but I think for new developers this logic will be more straight forward; if there isn't one add an item with quantity 1, otherwise increase quantity by 1
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

		// apply special offers/deals/promotions
		$total -= $this->offerService->calculateTotalDiscount($this->items);

		// calculate delivery cost
		$total += $this->deliveryCost->calculate($total);

		// round to nearest monetary value (i.e. $0.01 is the smallest denomination of currency, at least for USD)
		// normally I'd use the default PHP_ROUND_HALF_UP but that caused tests to fail
		$total = round($total, 2, PHP_ROUND_HALF_DOWN);
		return $total;
	}
}