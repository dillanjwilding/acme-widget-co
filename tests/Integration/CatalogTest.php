<?php declare(strict_types=1);
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Products\Products;
use AcmeWidgetCo\Catalog\Catalog;

final class CatalogTest extends TestCase {
	//private Products $products;
	private Catalog $catalog;

	protected function setUp(): void { // todo: confirm only run once
		parent::setUp();
		$products = new Products();
		$this->catalog = new Catalog($products);
	}

	public function testGetValidProduct(): void {
		$product = $this->catalog->getProduct('R01');
		$this->assertEquals($product['name'], 'Red Widget', 'Catalog getProduct is wrong');
	}

	public function testGetInvalidProduct(): void {
		$product = $this->catalog->getProduct('A01');
		$this->assertNull($product);
	}

	/*public function testGetAllProducts(): void {
		$products = $this->catalog->getAllProducts();
		// todo make assertions
	}*/
}
