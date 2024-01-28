<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Product;
use AcmeWidgetCo\Basket\Item;

final class ItemTest extends TestCase {
	protected function setUp(): void { // todo: confirm only run once
		parent::setUp();
	}

	// test get product and quantity
	// test increasing and decreasing quantity
	// test decreasing quantity when quantity is 0
	// test set quantity
	// test set quantity with value < 1, etc
	public function testPlaceholder() {
		$this->assertTrue(true);
	}
}
