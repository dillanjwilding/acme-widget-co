<?php declare(strict_types=1);
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Product\Product;
use AcmeWidgetCo\Product\Products;
use AcmeWidgetCo\Basket\Item;

final class ItemTest extends TestCase {
	private static Item $item;
	private static Product $product;

	public static function setUpBeforeClass(): void {
		$products = new Products();
		self::$product = $products->getProduct('R01');
		self::$item = new Item(self::$product);
	}

	/**
	 * @covers Item::getProduct
	 */
	public function testGetProduct(): void {
		$product = self::$item->getProduct();
		//$this->assertObjectEquals(self::$product, $product, '');
		$this->assertThat(self::$product, $this->equalTo($product));
	}

	/**
	 * @covers Item::getQuantity
	 */
	public function testGetQuantity(): void {
		$quantity = self::$item->getQuantity();
		$this->assertEquals(1, $quantity, 'Item->getQuantity()');
	}

	/**
	 * @covers Item::increaseQuantity
	 */
	public function testIncreaseQuantity(): void {
		self::$item->increaseQuantity();
		$quantity = self::$item->getQuantity();
		$this->assertEquals(2, $quantity, 'Item->increaseQuantity()');
	}

	/**
	 * @covers Item::decreaseQuantity
	 */
	public function testDecreaseQuantity(): void {
		self::$item->decreaseQuantity();
		$quantity = self::$item->getQuantity();
		$this->assertEquals(1, $quantity, 'Item->decreaseQuantity()');
	}

	// test decreasing quantity when quantity is 0
	// test set quantity
	// test set quantity with value < 1, etc
}
