<?php
namespace AcmeWidgetCo\Catalog;

use AcmeWidgetCo\Product\ProductService;

class CatalogFactory {
	public static function create(): Catalog {
		$productService = new ProductService();
		return new Catalog($productService);
	}
}