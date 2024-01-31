<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Products;
use AcmeWidgetCo\Product\Product;

final class ProductsTest extends TestCase {
	private static Products $products;

	public static function setUpBeforeClass(): void {
		self::$products = new Products();
	}

	/**
	 * @covers Products::getProduct
	 */
	public function testGetValidProduct(): void {
		$product = self::$products->getProduct('R01');
		$this->assertInstanceOf(Product::class, $product);
		$this->assertEquals('Red Widget', $product->getName());
		// don't really need to test getPrice() since ProductTest already does
	}

	/**
	 * @covers Products::getProduct
	 */
	public function testGetInvalidProduct(): void {
		$this->expectException(\Exception::class);
		$product = self::$products->getProduct('A01');
	}

	/**
	 * @covers Products::getAllProducts
	 */
	public function testGetAllProducts(): void {
		$products = self::$products->getAllProducts();
		$this->assertIsArray($products);
		foreach ($products as $product) {
			$this->assertInstanceOf(Product::class, $product);
		}
	}
}
