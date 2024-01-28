<?php
namespace AcmeWidgetCo\Basket;

use AcmeWidgetCo\Product\Product;

class Item {
	private Product $product;
	private int $quantity;

	public function __construct(Product $product, int $quantity = 1) {
		$this->product = $product;
		$this->quantity = $quantity;
	}

	public function getProduct(): Product {
		return $this->product;
	}

	public function getQuantity(): int {
		return $this->quantity;
	}

	public function increaseQuantity(): void {
		$this->quantity++;
	}

	public function decreaseQuantity(): void {
		if ($this->quantity > 1) {
			$this->quantity--;
		}
	}

	public function setQuantity($quantity): void {
		if ($quantity > 0) {
			$this->quantity = $quantity;
		}
	}
}