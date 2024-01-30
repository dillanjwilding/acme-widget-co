<?php
namespace AcmeWidgetCo\Offer;

/**
 * I created this to implement the "offer" discount logic and it's OOP-esque implementation but there's just something about it that I don't like because it doesn't seem scalable; there should be a better way to handle these offers than to create a class for every new one, also should be able to store it in the database more easily.
 */
class BuyR01GetR01HalfPrice {
	public function isValid($items) {
		foreach ($items as $code => $item) {
			// I was using $item->getProduct()->getCode() === 'R01'
			if ($code === 'R01' && $item->getQuantity() > 1) {
				return true;
			}
		}
		return false;
	}

	public function calculateDiscount($items) {
		$code = 'R01';
		if (isset($items[$code])) {
			$item = $items[$code];
			$price = $item->getProduct()->getPrice();
			$quantity = $item->getQuantity();
			$discount = floor($quantity / 2) * $price * 0.5;
			return $discount;
		}
		throw new Exception('');
	}
}