<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Products;

final class ProductsTest extends TestCase {
	private Products $products;

	protected function setUp(): void { // todo: confirm only run once
		parent::setUp();
		$this->products = new Products();
	}

	/**
	 * @covers Products::getProduct
	 */
	public function testGetProduct() {
		$product = $this->products->getProduct('R01');
		// todo check instance of Product
		$this->assertEquals('Red Widget', $product->getName());
		// don't really need to test getPrice() since ProductTest already does
	}

	/**
	 * @covers Products::getAllProducts
	 */
	public function testGetAllProducts() {
		$products = $this->products->getAllProducts();
		// assert array of Product objects
	}
}
