<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Product;
use AcmeWidgetCo\Product\Products;
use AcmeWidgetCo\Basket\Item;

final class ItemTest extends TestCase {
	private Item $item;
	private Product $product;

	protected function setUp(): void { // todo: confirm only run once
		parent::setUp();
		$products = new Products();
		$this->product = $products->getProduct('R01');
		$this->item = new Item($this->product);
	}

	/**
	 * @covers Item::getProduct
	 */
	public function testGetProduct() {
		$product = $this->item->getProduct();
		// todo compare $product and $this->product
	}

	/**
	 * @covers Item::getQuantity
	 */
	public function testGetQuantity() {
		$quantity = $this->item->getQuantity();
		$this->assertEquals(1, $quantity, 'Item->getQuantity()');
	}

	/**
	 * @covers Item::increaseQuantity
	 */
	public function testIncreaseQuantity() {
		$this->item->increaseQuantity();
		$quantity = $this->item->getQuantity();
		$this->assertEquals(2, $quantity, 'Item->increaseQuantity()');
	}

	/**
	 * @covers Item::decreaseQuantity
	 */
	public function testDecreaseQuantity() {
		$this->item->decreaseQuantity();
		$quantity = $this->item->getQuantity();
		$this->assertEquals(1, $quantity, 'Item->decreaseQuantity()');
	}

	// test decreasing quantity when quantity is 0
	// test set quantity
	// test set quantity with value < 1, etc
}
