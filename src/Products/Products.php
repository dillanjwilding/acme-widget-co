<?php
namespace AcmeWidgetCo\Products;

use AcmeWidgetCo\Product\Product;

// todo rename
class Products {
	private array $products = [];

	public function __construct() {
		// normally I'd request the data from a database
		// also, normally would use a strategy (?) such as Repository that would return results as Product objects rather than manually doing this
		// could move this to a file but seems unnecessary since this is example code
		$data = [
			['name' => 'Red Widget', 'code' => 'R01', 'price' => 32.95],
			['name' => 'Green Widget', 'code' => 'G01', 'price' => 24.95],
			['name' => 'Blue Widget', 'code' => 'B01', 'price' => 7.95]
		];
		foreach ($data as $product) {
			// @todo validate $product has required values
			$this->products[$product['code']] = new Product($product['name'], $product['code'], $product['price']);
		}
	}

	public function getProduct($code): Product {
		// check isset($this->products[$code])
		return $this->products[$code];
	}

	// do I need this function?
	public function getAllProducts(): array {
		return $this->products;
	}
}