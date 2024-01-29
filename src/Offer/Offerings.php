<?php
namespace AcmeWidgetCo\Offer;

// @todo rename to OfferManager or OfferService or something
class Offerings {
	private array $offers = [];

	public function __construct() {
		$this->offers = [
			new Offer()
		];
	}

	public function applyOffer(array $products) {
		$offset = 0;
		if (!empty($this->offers)) {
			foreach ($this->offers as $offer) {
				if ($offer->isValid($products)) {
					$offset += $offer->applyOffer($products);
				}
			}
		}
		return $offset;
	}
}