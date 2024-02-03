<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Offer\BuyOneGetOne;

final class BuyOneGetOneTest extends TestCase {
	/**
	 * @covers BuyOneGetOne
	 */
	public function testBuyOneGetOne(): void {
		$offer = new BuyOneGetOne(0.5, 'R01', 'R01');
		$this->assertInstanceOf(BuyOneGetOne::class, $offer);
	}
}
