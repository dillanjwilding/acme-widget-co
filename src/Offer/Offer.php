<?php
namespace AcmeWidgetCo\Offer;

// @todo rename to OfferManager or OfferService or something
class Offer {
	private array $offerings = [];

	public function __construct(?array $offerings = []) {
		$this->offerings = $offerings;
	}

	public function applyOffer(array $products) {
		if (!empty($this->offerings)) {
			foreach ($this->offerings as $offering) {
				$offering->applyOffer($products);
			}
		}
	}
}