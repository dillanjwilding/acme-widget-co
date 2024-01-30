<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Product;
use AcmeWidgetCo\Basket\Item;

final class ProductTest extends TestCase {
	/**
	 * This test is on the more fragile side, if Product data changed, I
	 * wouldn't design tests like this because their failure wouldn't be
	 * meaningful.
	 * 
	 * If an API designed around Product data needed properties, we could check
	 * the "shape" and value types of products rather than actual values.
	 * 
	 * @covers Product::getName
	 * @covers Product::getCode
	 * @covers Product::getPrice
	 */
	public function testProductMethods(): void {
		$product = new Product('Test', '01', 12.34);
		$this->assertEquals('Test', $product->getName());
		$this->assertEquals('01', $product->getCode());
		$this->assertEquals(12.34, $product->getPrice());
	}
}
