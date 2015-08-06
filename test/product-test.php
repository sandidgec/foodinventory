<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/product.php");

/**
 * Full PHPUnit test for the Product class
 *
 * This is a complete PHPUnit test of the Product class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Product
 * @author Marie Vigil <marie@jtdesignsolutions.com>
 **/
class ProductTest extends InventoryTextTest {
	/**
	 * valid productId to use
	 * @var int $VALID_productId
	 **/
	protected $VALID_productId = 1;

	/**
	 * invalid productId to use
	 * @var int $INVALID_productId
	 **/
	protected $INVALID_productId = 4294967296;

	/**
	 * validUserId to use
	 * @var int $VALID_userId
	 **/
	protected $VALID_userId = 1;

	/**
	 * invalid userId to use
	 * @var int $INVALID_userId
	 **/
	protected $INVALID_userId = 429496789;

	/**
	 * valid vendorId to use
	 * @var int $VALID_vendorId
	 **/
	protected $VALID_vendorId = 1;

	/**
	 * invalid vendorId to use
	 * @var int $INVALID_vendorId
	 **/
	protected $INVALID_vendorId = 4294967296;

	/**
	 * valid sku to use
	 * @var int $VALID_sku
	 **/
	protected $VALID_sku = 1;

	/**
	 * invalid sku to use
	 * @var int $INVALID_sku
	 **/
	protected $INVALID_sku = 4294967296;

	/**
	 * valid leadTime to use
	 * @var int $VALID_leadTime
	 **/
	protected $VALID_leadTime = 1;

	/**
	 * invalid leadTime to use
	 * @var int $INVALID_leadTime
	 **/
	protected $INVALID_leadTime = 4294967296;

	/**
	 * valid title to use
	 * @var string $VALID_title
	 **/
	protected $VALID_title = "ksafklsjfdsfoiekanfd";

	/**
	 * invalid title to use
	 * @var str $INVALID_title
	 **/
	protected $INVALID_title = "kksajfsdfisdfosereoejiorjweirjewiorjaeiowfjndsjndnvnd";


	/**
	 * valid description to use
	 * @var string $VALID_description
	 **/
	protected $VALID_description = "ksafklsjfdsfoiekanfd";

	/**
	 * invalid description to use
	 * @var str $INVALID_description
	 **/
	protected $INVALID_description = "kksajfsdfisdfosereoejiorjweirjewiorjaeiowfjndsjndnvnd";

	/**
	 * test inserting a valid Product and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_productId, $this->VALIDuserId, $this->VALID_vendorId, $this->VALID_leadTime, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByvendorId($this->getPDO(), $product->getvendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getproductId(), $this->VALID_productId);
	}

	/**
	 * test inserting a Product that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProduct() {
		// create a product with a non null Product and watch it fail
		$product = new Product(InventoryTextTest::INVALID_KEY, $this->INVALID_productId, $this->INVALID_vendorId, $this->INVALID_leadTime, $this->INVALID_description);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting a Product and regrabbing it from mySQL
	 **/
	public function testGetValidProductByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert it into mySQL
		$product = new Product(null, $this->VALID_productId, $this->VALID_vendorId, $this->VALID_leadTIme, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getProductId(), $this->VALID_productId);
		$this->assertSame($pdoProduct->getvendorId(), $this->VALID_vendorId);
	}

	/**
	 * test grabbing a Product that does not exist
	 **/
	public function testGetInvalidProductByProductId() {
		// grab a Product id that exceeds the maximum allowable Product id
		$product = Product::getProductByProductId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($product);
	}

	/**
	 * test grabbing a Product by vendorId
	 **/
	public function testGetValidProductByvendorId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_productId, $this->VALID_vendorId, $this->VALID_leadTime, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getMovementByProductId($this->getPDO(), $product->getvendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getProductId(), $this->VALID_vendorId, $this->VALID_leadTime, $this->VALID_description);
		$this->assertSame($pdoProduct->getvendorId(), $this->VALID_vendorId);
	}
}




