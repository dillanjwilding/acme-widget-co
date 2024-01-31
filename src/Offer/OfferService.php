<?php
namespace AcmeWidgetCo\Offer;

use AcmeWidgetCo\Basket\Item;

class OfferService {
	/** @var array<Offer> */
	private array $offers = [];

	public function __construct() {
		// should be able to load active offers from the database checking if today's date is between the start and end date
		// $this->offers = OfferRepository->filter([ ... ])
		// but since we don't have a database, I'll load it manually
		$offers = [
			[
				'offer_product' => 'R01',
				'discounted_product' => 'R01',
				'discount_rate' => 0.5
			]
		];
		foreach ($offers as $offer) {
			$this->offers[] = new Offer($offer['discount_rate'], $offer['offer_product'], $offer['discounted_product']);
		}
	}

	/**
	 * @param array<string, Item> $items
	 */
	public function calculateTotalDiscount(array $items): float {
		$offset = 0;
		if (!empty($this->offers)) {
			foreach ($this->offers as $offer) {
				if ($offer->isValid($items)) {
					$offset += $offer->calculateDiscount($items);
				}
			}
		}
		return $offset;
	}
}