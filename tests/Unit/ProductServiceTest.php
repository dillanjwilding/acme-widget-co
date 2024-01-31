<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\ProductService;
use AcmeWidgetCo\Product\Product;

final class ProductServiceTest extends TestCase {
	private static ProductService $productService;

	public static function setUpBeforeClass(): void {
		self::$productService = new ProductService();
	}

	/**
	 * @covers ProductService::getProduct
	 */
	public function testGetValidProduct(): void {
		$product = self::$productService->getProduct('R01');
		$this->assertInstanceOf(Product::class, $product);
		$this->assertEquals('Red Widget', $product->getName());
		// don't really need to test getPrice() since ProductTest already does
	}

	/**
	 * @covers ProductService::getProduct
	 */
	public function testGetInvalidProduct(): void {
		$this->expectException(\Exception::class);
		$product = self::$productService->getProduct('A01');
	}

	/**
	 * @covers ProductService::getAllProducts
	 */
	public function testGetAllProducts(): void {
		$products = self::$productService->getAllProducts();
		$this->assertIsArray($products);
		foreach ($products as $product) {
			$this->assertInstanceOf(Product::class, $product);
		}
	}
}
