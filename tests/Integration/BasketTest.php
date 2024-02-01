<?php declare(strict_types=1);
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Catalog\Catalog;
use AcmeWidgetCo\Catalog\CatalogFactory;
use AcmeWidgetCo\Basket\Basket;
use AcmeWidgetCo\Basket\BasketFactory;

final class BasketTest extends TestCase {
	private static Catalog $catalog;

	public static function setUpBeforeClass(): void {
		self::$catalog = CatalogFactory::create();
	}

	/**
	 * @covers BasketFactory::create
	 */
	public function testBasket(): void {
		$basket = BasketFactory::create(self::$catalog);
		$this->assertInstanceOf(Basket::class, $basket);
	}

	/**
	 * @depends testBasket
	 * @param array<string> $products
	 * @dataProvider productDataProvider
	 * @covers Basket::addProduct
	 * @covers Basket::getTotal
	 */
	public function testGetTotalWithProducts(array $products, float $total, string $message): void {
		$basket = BasketFactory::create(self::$catalog);
		foreach ($products as $product) {
			$basket->addProduct($product);
		}
		$this->assertEquals($total, $basket->getTotal(), $message);
	}

	/**
	 * @return array<array<string, mixed>>
	 */
	public static function productDataProvider(): array {
		return [
			[
				'products' => ['B01', 'G01'],
				'total' => 37.85,
				'message' => 'Shipping for orders under $50'
			], [
				'products' => ['R01', 'R01'],
				'total' => 54.37,
				'message' => 'Buy one R01, get the second half off'
			], [
				'products' => ['R01', 'G01'],
				'total' => 60.85,
				'message' => 'Shipping for orders between $50 and $90'
			], [
				'products' => ['B01', 'B01', 'R01', 'R01', 'R01'],
				'total' => 98.27,
				'message' => 'Shipping for orders over $90'
			]
		];
	}
}
