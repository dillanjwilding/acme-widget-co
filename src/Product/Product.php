<?php
namespace AcmeWidgetCo\Product;

class Product {
	private string $name;
	private string $code;
	private float $price;

	public function __construct(string $name, string $code, float $price) {
		$this->name = $name;
		$this->code = $code;
		// possibly data validation, verify price only has 2 digits right of the decimal point or round to it
		$this->price = $price;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getCode(): string {
		return $this->code;
	}

	public function getPrice(): float {
		return $this->price;
	}
}