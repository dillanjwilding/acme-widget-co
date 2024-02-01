<?php
namespace AcmeWidgetCo\Catalog;

use AcmeWidgetCo\Product\ProductService;
use AcmeWidgetCo\Product\Product;

/** 
 * Transitioned to storing and using ProductService object because I think there's a case where if a Catalog object was created with a ProductService and immediately we get the Products, the data could be outdated and stale by time of use.
 */
class Catalog {
	private ProductService $productService;
	//private array $products = [];

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
	public function __construct(ProductService $productService) {
		$this->productService = $productService;
		//$this->products = $this->productService->getAllProducts(); 
	}

	public function getProduct(string $code): Product {
		return $this->productService->getProduct($code);
		//return $this->products[$code] ?? null;
	}

	/* There are other functions I could add but right now there is no use-case:

	// getting all products in the catalog could be useful especially when introducing a UI but for this project it isn't necessary (yet)
	public function getAllProducts(): array {
		return $this->productService->getAllProducts();
		//return $this->products;
	}*/
}