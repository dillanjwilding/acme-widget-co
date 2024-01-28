<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Catalog\Catalog;

final class CatalogTest extends TestCase {
	protected function setUp(): void { // todo: confirm only run once
		parent::setUp();
	}

	// test creating catalog and getting products, only need this if I create a Factory, otherwise I can delete it since passing in products just to call get products seems like a not valuable test so unnecessary to have
	public function testPlaceholder() {
		$this->assertTrue(true);
	}
}
