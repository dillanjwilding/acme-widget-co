<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Delivery\DeliveryCost;

final class DeliveryCostTest extends TestCase {
	protected function setUp(): void { // todo: confirm only run once
		parent::setUp();
	}

	public function testPlaceholder() {
		$this->assertTrue(true);
	}
	// todo write test that ensures that there is a delivery cost tier with min of 0
}
