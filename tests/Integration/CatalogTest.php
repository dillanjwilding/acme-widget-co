<?php declare(strict_types=1);
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Products;
use AcmeWidgetCo\Catalog\Catalog;

final class CatalogTest extends TestCase {
	//private Products $products;
	private Catalog $catalog;

	protected function setUp(): void { // todo: confirm only run once
		parent::setUp();
		$products = new Products();
		$this->catalog = new Catalog($products);
	}

	/**
	 * This test is on the more fragile side, if Product data changed, I
	 * wouldn't design tests like this because their failure wouldn't be
	 * meaningful.
	 * 
	 * If an API designed around Product data needed properties, we could check
	 * the "shape" and value types of products rather than actual values.
	 * 
	 * @covers Catalog::getProduct
	 * @covers Product::getName
	 * @covers Product::getCode
	 * @covers Product::getPrice
	 */
	public function testGetValidProduct(): void {
		$product = $this->catalog->getProduct('R01');
		$this->assertEquals($product->getName(), 'Red Widget', 'Catalog getProduct is wrong');
		$this->assertEquals($product->getCode(), 'R01', 'Catalog getProduct is wrong');
		$this->assertEquals($product->getPrice(), 32.95, 'Catalog getProduct is wrong');
	}

	/**
	 * @covers Catalog::getProduct
	 */
	public function testGetInvalidProduct(): void {
		$product = $this->catalog->getProduct('A01');
		$this->assertNull($product);
	}

	/*public function testGetAllProducts(): void {
		$products = $this->catalog->getAllProducts();
		// todo make assertions
	}*/
}
