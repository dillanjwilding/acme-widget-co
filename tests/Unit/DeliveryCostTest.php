<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Delivery\DeliveryCost;

final class DeliveryCostTest extends TestCase {
	/**
	 * @covers DeliveryCost
	 */
	public function testValidDeliveryCost(): void {
		$deliveryCost = new DeliveryCost();
		$this->assertInstanceOf(DeliveryCost::class, $deliveryCost);
		// ->calculate() ?
	}

	/**
	 * @covers DeliveryCost
	 */
	public function testInvalidDeliveryCost(): void {
		$this->expectException(\Exception::class);
		$deliveryCost = new DeliveryCost('invalid');
	}

	// todo write test that ensures that there is a delivery cost tier with min of 0
}
