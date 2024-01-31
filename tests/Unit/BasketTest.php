<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\ProductService;
use AcmeWidgetCo\Catalog\Catalog;
use AcmeWidgetCo\Delivery\DeliveryCost;
use AcmeWidgetCo\Offer\OfferService;
use AcmeWidgetCo\Basket\Basket;

final class BasketTest extends TestCase {
	/**
	 * @covers Basket
	 */
	public function testBasket(): void {
		$productService = new ProductService();
		$catalog = new Catalog($productService);
		$deliveryCost = new DeliveryCost();
		$offerService = new OfferService();
		$basket = new Basket($catalog, $deliveryCost, $offerService);
		$this->assertInstanceOf(Basket::class, $basket);
	}
}
