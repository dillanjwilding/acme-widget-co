<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\ProductService;
use AcmeWidgetCo\Product\Product;
use AcmeWidgetCo\Catalog\Catalog;

final class CatalogTest extends TestCase {
	private static Catalog $catalog;

	public static function setUpBeforeClass(): void {
		$productService = new ProductService();
		self::$catalog = new Catalog($productService);
	}

	/**
	 * This test is on the more fragile side, if Product data changed, I
	 * wouldn't design tests like this because their failure wouldn't be
	 * meaningful.
	 * 
	 * If an API designed around Product data needed properties, we could check
	 * the "shape" and value types of products rather than actual values.
	 * 
	 * @covers Catalog::getProduct
	 * @covers Product::getName
	 * @covers Product::getCode
	 * @covers Product::getPrice
	 */
	public function testGetValidProduct(): void {
		$product = self::$catalog->getProduct('R01');
		$this->assertInstanceOf(Product::class, $product);
		$this->assertEquals('Red Widget', $product->getName(), 'Catalog getProduct is wrong');
		$this->assertEquals('R01', $product->getCode(), 'Catalog getProduct is wrong');
		$this->assertEquals(32.95, $product->getPrice(), 'Catalog getProduct is wrong');
	}

	/**
	 * @covers Catalog::getProduct
	 */
	public function testGetInvalidProduct(): void {
		$this->expectException(\Exception::class);
		$product = self::$catalog->getProduct('A01');
	}

	/*public function testGetAllProducts(): void {
		$products = self::$catalog->getAllProducts();
		// todo make assertions
	}*/
}
