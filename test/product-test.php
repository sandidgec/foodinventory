<?php
/**
 * product unit test for foodinventory
 *
 * This product unit test is a single class within the overall foodinventory application
 *
 * @author Marie Vigil <marie@jtdesignsolutions>
 *
 **/




// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/product.php");
require_once(dirname(__DIR__) . "/php/classes/vendor.php");

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
	 * @var int $vendor
	 **/
	protected $vendor = null;


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
	protected $VALID_title = 'test';

	/**
	 * invalid title to use
	 * @var string $INVALID_title
	 **/
	protected $INVALID_title = null;


	/**
	 * valid description to use
	 * @var string $VALID_description
	 **/
	protected $VALID_description = 'kids';

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
		$this->vendor = new Vendor(null, "Joe Cool", "joecool@gmail.com", "Joe Cool", 5055555555);
		$this->vendor->insert($this->getPDO());
	}



	/**
	 * test inserting a valid Product and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByVendorId($this->getPDO(), $product->getvendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
		}

	}

	/**
	 * test inserting a Product that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProduct() {
		// create a product with a non null Product and watch it fail
		$product = new Product(InventoryTextTest::INVALID_KEY,
			$this->vendor->getVendorId(), $this->VALID_sku,
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
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getSku(), $product->getSku());
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
	$numRows = $this->getConnection()->getRowCount("product");

	// create a new Product and insert to into mySQL
	$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_sku,
		$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
	$product->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoProducts = Product::getProductByVendorId($this->getPDO(), $product->getvendorId());
	$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
	foreach($pdoProducts as $pdoProduct) {
		$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
		$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
		$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
		$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
		}
	}

	/**
	 * test grabbing a Product by sku
	 **/
	public function testGetValidProductBySku() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductBySku($this->getPDO(), $product->getSku());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
		}
	}


	/**
	 * test grabbing a Product by leadTime
	 **/
	public function testGetValidProductByLeadTIme() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByLeadTime($this->getPDO(), $product->getLeadTime());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
		}
	}

	/**
	 * test grabbing a Product by title
	 **/
	public function testGetValidProductByTitle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByTitle($this->getPDO(), $product->getTitle());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
		}
	}


	/**
	 * test grabbing a Product by description
	 **/
	public function testGetValidProductByDescription() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_sku,
			$this->VALID_leadTime, $this->VALID_title, $this->VALID_description);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByDescription($this->getPDO(), $product->getDescription());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
		}
	}

}






