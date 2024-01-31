<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Products;
use AcmeWidgetCo\Catalog\Catalog;
use AcmeWidgetCo\Delivery\DeliveryCost;
use AcmeWidgetCo\Offer\Offerings;
use AcmeWidgetCo\Basket\Basket;

final class BasketTest extends TestCase {
	/**
	 * @covers Basket
	 */
	public function testBasket(): void {
		$products = new Products();
		$catalog = new Catalog($products);
		$delivery = new DeliveryCost();
		$offerings = new Offerings();
		$basket = new Basket($catalog, $delivery, $offerings);
		$this->assertInstanceOf(Basket::class, $basket);
	}
}
