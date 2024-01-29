<?php declare(strict_types=1);
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Products;
use AcmeWidgetCo\Catalog\Catalog;
use AcmeWidgetCo\Delivery\DeliveryCost;
use AcmeWidgetCo\Offer\Offerings;
use AcmeWidgetCo\Basket\Basket;

final class BasketTest extends TestCase {
	private Catalog $catalog;
	private DeliveryCost $delivery;
	private Offerings $offerings;

	// probably only needs to run once, but this runs before every test
	// use setUpBeforeClass instead?
	protected function setUp(): void { 
		parent::setUp();
		$products = new Products();
		$this->catalog = new Catalog($products);
		$this->delivery = new DeliveryCost();
		$this->offerings = new Offerings();
	}

	/**
	 * @dataProvider dataProvider
	 * @covers Basket::addProduct
	 * @covers Basket::getTotal
	 */
	public function testBasketWithProducts($products, $total, $message): void { // include total calculation in name for additional context?
		// use factory?
		$basket = new Basket($this->catalog, $this->delivery, $this->offerings);
		foreach ($products as $product) {
			$basket->addProduct($product);
		}
		$this->assertEquals($basket->getTotal(), $total, $message);
	}

	public static function dataProvider() {
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
