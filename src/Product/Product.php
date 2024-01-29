<?php
namespace AcmeWidgetCo\Product;

class Product {
	private string $name;
	private string $code;
	private float $price;

	public function __construct(string $name, string $code, float $price) {
		$this->name = $name;
		$this->code = $code;
		$this->price = $price;
	}

	// todo add getter and setters since I made class properties private, I think I need at least getPrice() for total cost calculation, may not need the others
	public function getPrice(): float {
		return $this->price;
	}

	// I don't know if this is the best approach for the:
	//	- buy 1 red widget, get the second half off/price
	public function applyPromotion(): void {
		// I think I moved on from the idea of having offers/deals/promotions here... 
		// todo remove this
	}
}