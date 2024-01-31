<?php
namespace AcmeWidgetCo\Catalog;

use AcmeWidgetCo\Product\Products;
use AcmeWidgetCo\Product\Product;

// may want to add a Factory where you don't have to pass products in, but then I'd have to figure out the mechanism noted in the other comment.
class Catalog {
	/** @var array<string, Product> */
	private array $products = [];

	/**
	 * I didn't use a static array so multiple catalogs could be instantiated
	 * with different products but right now I don't have a mechanism for
	 * handling that unless getAllProducts() determines that. If I keep it the
	 * way it is, I think I need to add something to selectively get only the
	 * products for this catalog and differentiate it from other catalogs
	 * products.
	 * 
	 * I didn't want to use $product->getProduct($code), opting to batch those
	 * requests.
	 */
	public function __construct(Products $products) {
		// @todo: rename products to something else as it's not an array of Product objects but a product manager
		$this->products = $products->getAllProducts(); 
	}

	public function getProduct(string $code): ?Product {
		return $this->products[$code] ?? null;
	}

	/* There are other functions I could add but right now there is no use-case:

	// this would be able to be used for batching getProduct($code) requests
	getProducts(array $codes): array {
		// there's probably a better way to do this but I didn't think about it too hard since I wasn't using it
		$products = [];
		foreach ($codes as $code) {
			$products[$code] = $this->products[$code];
		}
		return $products;
	}

	// getting all products in the catalog could be useful especially when introducing a UI but for this project it isn't necessary (yet)
	public function getAllProducts(): array {
		return $this->products;
	}*/
}