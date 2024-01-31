<?php declare(strict_types=1);
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Products;
use AcmeWidgetCo\Catalog\Catalog;
use AcmeWidgetCo\Delivery\DeliveryCost;
use AcmeWidgetCo\Offer\Offerings;
use AcmeWidgetCo\Basket\Basket;

// todo while this works, I probably want to use BasketFactory instead or possibly should test both
final class BasketTest extends TestCase {
	private static Catalog $catalog;
	private static DeliveryCost $delivery;
	private static Offerings $offerings;

	public static function setUpBeforeClass(): void {
		$products = new Products();
		self::$catalog = new Catalog($products);
		self::$delivery = new DeliveryCost();
		self::$offerings = new Offerings();
	}

	/**
	 * @param array<string> $products
	 * @dataProvider productDataProvider
	 * @covers Basket::addProduct
	 * @covers Basket::getTotal
	 */
	public function testBasketWithProducts(array $products, float $total, string $message): void { // include total calculation in name for additional context?
		// use factory?
		$basket = new Basket(self::$catalog, self::$delivery, self::$offerings);
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
