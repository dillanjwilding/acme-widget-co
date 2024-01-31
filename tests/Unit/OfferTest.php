<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Offer\Offer;

final class OfferTest extends TestCase {
	/**
	 * @covers Offer
	 */
	public function testOffer(): void {
		$offer = new Offer(0.5, 'R01', 'R01');
		$this->assertInstanceOf(Offer::class, $offer);
	}
}
