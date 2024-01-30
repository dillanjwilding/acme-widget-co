<?php
namespace AcmeWidgetCo\Offer;

// todo rename OfferManager, OfferService, OfferCatalog, something else besides Offerings
class Offerings {
	private array $offers = [];

	public function __construct() {
		// should be able to load active offers from the database checking if today's date is between the start and end date
		$this->offers = [
			new BuyR01GetR01HalfPrice()
		];
	}

	public function applyOffers(array $items) {
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