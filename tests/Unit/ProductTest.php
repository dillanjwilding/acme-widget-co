<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Product;
use AcmeWidgetCo\Basket\Item;

final class ProductTest extends TestCase {
	/**
	 * @covers Product::getName
	 * @covers Product::getCode
	 * @covers Product::getPrice
	 */
	public function testProductMethods() {
		$product = new Product('Test', '01', 12.34);
		$this->assertEquals('Test', $product->getName());
		$this->assertEquals('01', $product->getCode());
		$this->assertEquals(12.34, $product->getPrice());
	}
}
