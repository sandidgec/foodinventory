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
	 * Vendor id is for foreign key relation
	 * @var int $vendorId
	 **/
	protected $vendorId = null;

	/**
	 * invalid vendor Id to use
	 * @var int $INVALID_vendorId
	 **/
	protected $INVALID_vendorId = null;


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
	protected $VALID_title = null;

	/**
	 * invalid title to use
	 * @var string $INVALID_title
	 **/
	protected $INVALID_title = null;


	/**
	 * valid description to use
	 * @var string $VALID_description
	 **/
	protected $VALID_description = null;

	/**
	 * invalid description to use
	 * @var string $INVALID_description
	 **/
	protected $INVALID_description = null;


	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Vendor id
		$this->vendorId = new VendorId(null, "Joe Cool", "joecool@gmail.com", "Joe Cool", 5055555555);
		$this->vendorId->insert($this->getPDO());

		$this->VALID_description = str_repeat("kids ", 25);
		$this->INVALID_description = str_repeat("dogs and kids ", 25);
	}



	/**
	 * test inserting a valid Product and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null,
			$this->VALID_productId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
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
		$product = new Product(InventoryTextTest::INVALID_KEY,
			$this->VALID_productId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting a Product and regrabbing it from mySQL
	 **/
	public function testGetValidProductByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert it into mySQL
		$product = new Product(null,
			$this->VALID_productId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
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
public function testGetValidProductByVendorId() {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("vendor");

	// create a new Product and insert to into mySQL
	$product = new Product(null,
		$this->VALID_productId, $this->VALID_vendorId, $this->VALID_sku,
		$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
	$product->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoProduct = Product::getMovementByProductId($this->getPDO(), $product->getvendorId());
	$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
	$this->assertSame($pdoProduct->getProductId(),
		$this->VALID_vendorId, $this->VALID_sku,
		$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
	$this->assertSame($pdoProduct->getvendorId(), $this->VALID_vendorId);
}

	/**
	 * test grabbing a Product by sku
	 **/
	public function testGetValidProductBySku() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("sku");

		// create a new Product and insert to into mySQL
		$product = new Product(null,
			$this->VALID_productId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getMovementByProductId($this->getPDO(), $product->getvendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getProductId(),
			$this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
	}


	/**
	 * test grabbing a Product by leadTime
	 **/
	public function testGetValidProductByLeadTIme() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("leadTime");

		// create a new Product and insert to into mySQL
		$product = new Product(null,
			$this->VALID_productId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getMovementByProductId($this->getPDO(), $product->getvendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getProductId(),
			$this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
	}

	/**
	 * test grabbing a Product by title
	 **/
	public function testGetValidProductByTitle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("title");

		// create a new Product and insert to into mySQL
		$product = new Product(null,
			$this->VALID_productId, $this->VALID_userId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getMovementByProductId($this->getPDO(), $product->getvendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getProductId(),
			$this->VALID_userId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
	}


	/**
	 * test grabbing a Product by description
	 **/
	public function testGetValidProductByDescription() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("description");

		// create a new Product and insert to into mySQL
		$product = new Product(null,
			$this->VALID_productId, $this->VALID_userId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getMovementByProductId($this->getPDO(), $product->getvendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getProductId(),
			$this->VALID_userId, $this->VALID_vendorId, $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$this->assertSame($pdoProduct->getdescription(), $this->VALID_description);
	}

}




