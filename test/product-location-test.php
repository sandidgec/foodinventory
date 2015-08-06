<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/product-location.php");
require_once(dirname(__DIR__) . "/php/classes/product.php");
require_once(dirname(__DIR__) . "/php/classes/vendor.php");
require_once(dirname(__DIR__) . "/php/classes/location.php");
require_once(dirname(__DIR__) . "/php/classes/unit-of-measure.php");


/**
 * Full PHPUnit test for the ProductLocation class
 *
 * This is a complete PHPUnit test of the ProductLocation class.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see ProductLocation
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class ProductLocationTest extends InventoryTextTest {
	/**
	 * valid locationId to use
	 * @var int $VALID_locationId
	 **/
	protected $VALID_locationId = 1;

	/**
	 * invalid locationId to use
	 * @var int $INVALID_locationId
	 **/
	protected $INVALID_locationId = 4294967296;

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
	 * valid unitId to use
	 * @var int $VALID_unitId
	 **/
	protected $VALID_unitId = 1;

	/**
	 * invalid unitId to use
	 * @var int $INVALID_unitId
	 **/
	protected $INVALID_unitId = 4294967296;

	/**
	 * valid quantity to use
	 * @var float $VALID_quantity
	 **/
	protected $VALID_quantity = 400.25;

	/**
	 * valid second quantity to use
	 * @var float $VALID_quantity2
	 **/
	protected $VALID_quantity2 = 225.50;

	/**
	 * invalid quantity to use
	 * @var float $INVALID_quantity
	 **/
	protected $INVALID_quantity = 42949.67296;

	/**
	 * creating a null Product object
	 * for global scope
	 * @var Product $product
	 **/
	protected $product = null;

	/**
	 * creating a null fromLocation object
	 * for global scope
	 * @var Location $location
	 **/
	protected $location = null;

	/**
	 * creating a null UnitOfMeasure object
	 * for global scope
	 * @var UnitOfMeasure $unitOfMeasure
	 **/
	protected $unitOfMeasure = null;


	public function setUp() {
		parent::setUp();

		$vendorId = null;
		$name = "TruFork";
		$contactName = "Trevor Rigler";
		$email = "trier@cnm.edu";
		$phoneNumber = "5053594687";

		$vendor = new Vendor($vendorId, $name, $contactName, $email, $phoneNumber);
		$vendor->insert($this->getPDO());

		$productId = null;
		$vendorId = $vendor->getVendorId();
		$description = "A glorius bead to use";
		$leadTime = "10 days";
		$sku = "thtfr354";
		$title = "Bead-Green-Blue-Circular";

		$this->product = new Product($productId, $vendorId, $description, $leadTime, $sku, $title);
		$this->product->insert($this->getPDO());

		$locationId = null;
		$description = "Back Stock";
		$storageCode = "BS";

		$this->location = new Location($locationId, $vendorId, $description, $storageCode);
		$this->location->insert($this->getPDO());

		$unitId = null;
		$unitCode = "pk";
		$quantity = "10.50";

		$this->unitOfMeasure = new UnitOfMeasure($unitId, $unitCode, $quantity);
		$this->unitOfMeasure->insert($this->getPDO());
	}


	/**
	 * test inserting a valid ProductLocation and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProductLocation() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productLocation");

		// create a new ProductLocation and insert to into mySQL
		$productLocation = new ProductLocation($this->location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductLocation = ProductLocation::getProductLocationByLocationIdAndProductId($this->getPDO(), $this->location->getLocationId(), $this->product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productLocation"));
		$this->assertSame($pdoProductLocation->getUnitId, $this->unitOfMeasure->getUnitId());
		$this->assertSame($pdoProductLocation->getQuantity(), $this->VALID_quantity);
	}

	/**
	 * test inserting a ProductLocation that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProfile() {
		// create a productLocation with a non null locationId and watch it fail
		$productLocation = new ProductLocation(InventoryTextTest::INVALID_KEY, $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->insert($this->getPDO());
	}

	/**
	 * test inserting a ProductLocation, editing it, and then updating it
	 **/
	public function testUpdateValidProductLocation() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productLocation");

		// create a new ProductLocation and insert to into mySQL
		$productLocation = new ProductLocation($this->location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->insert($this->getPDO());

		// edit the ProductLocation and update it in mySQL
		$productLocation->setQuantity($this->VALID_quantity2);
		$productLocation->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductLocation = ProductLocation::getProductLocationByLocationIdAndProductId($this->getPDO(), $this->location->getLocationId(), $this->product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productLocation"));
		$this->assertSame($pdoProductLocation->getUnitId, $this->unitOfMeasure->getUnitId());
		$this->assertSame($pdoProductLocation->getQuantity(), $this->VALID_quantity);
	}

	/**
	 * test updating a ProductLocation that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProductLocation() {
		// create a ProductLocation and try to update it without actually inserting it
		$productLocation = new ProductLocation($this->location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->update($this->getPDO());
	}

	/**
	 * test creating a ProductLocation and then deleting it
	 **/
	public function testDeleteValidProductLocation() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productLocation");

		// create a new ProductLocation and insert to into mySQL
		$productLocation = new ProductLocation($this->location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->insert($this->getPDO());

		// delete the ProductLocation from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productLocation"));
		$productLocation->delete($this->getPDO());

		// grab the data from mySQL and enforce the ProductLocation does not exist
		$pdoProductLocation = ProductLocation::getProductLocationByLocationIdAndProductId($this->getPDO(), $this->location->getLocationId(), $this->product->getProductId());
		$this->assertNull($pdoProductLocation);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("productLocation"));
	}

	/**
	 * test deleting a ProductLocation that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProfile() {
		// create a ProductLocation and try to delete it without actually inserting it
		$productLocation = new ProductLocation($this->location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->delete($this->getPDO());
	}

	/**
	 * test inserting a ProductLocation and regrabbing it from mySQL
	 **/
	public function testGetValidProductLocationByLocationIdAndProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productLocation");

		// create a new ProductLocation and insert to into mySQL
		$productLocation = new ProductLocation($this->location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductLocation = ProductLocation::getProductLocationByLocationIdAndProductId($this->getPDO(), $this->location->getLocationId(), $this->product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productLocation"));
		$this->assertSame($pdoProductLocation->getUnitId, $this->unitOfMeasure->getUnitId());
		$this->assertSame($pdoProductLocation->getQuantity(), $this->VALID_quantity);
	}

	/**
	 * test grabbing a ProductLocation that does not exist
	 **/
	public function testGetInvalidProductLocationByLocationIdAndProfileId() {
		// grab a location id that exceeds the maximum allowable location id
		$productLocation = ProductLocation::getProductLocationByLocationIdAndProductId($this->getPDO(), InventoryTextTest::INVALID_KEY, $this->product->getProductId());
		$this->assertNull($productLocation);
	}

	/**
	 * test grabbing a ProductLocation by locationId
	 **/
	public function testGetValidProductLocationByLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productLocation");

		// create a new ProductLocation and insert to into mySQL
		$productLocation = new ProductLocation($this->location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductLocation = ProductLocation::getProductLocationByLocationId($this->getPDO(), $this->location->getLocationId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productLocation"));
		$this->assertSame($pdoProductLocation->getProductId, $this->product->getProductId());
		$this->assertSame($pdoProductLocation->getUnitId, $this->unitOfMeasure->getUnitId());
		$this->assertSame($pdoProductLocation->getQuantity(), $this->VALID_quantity);
	}

	/**
	 * test grabbing a ProductLocation by locationId that does not exist
	 **/
	public function testGetInvalidProductLocationByLocationId() {
		// grab an locationId that does not exist
		$productLocation = ProductLocation::getProductLocationByLocationId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($productLocation);
	}

	/**
	 * test grabbing a ProductLocation by productId
	 **/
	public function testGetValidProductLocationByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productLocation");

		// create a new ProductLocation and insert to into mySQL
		$productLocation = new ProductLocation($this->location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->VALID_quantity);
		$productLocation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductLocation = ProductLocation::getProductLocationByLocationId($this->getPDO(), $this->product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productLocation"));
		$this->assertSame($pdoProductLocation->getLocationId, $this->location->getLocationId());
		$this->assertSame($pdoProductLocation->getUnitId, $this->unitOfMeasure->getUnitId());
		$this->assertSame($pdoProductLocation->getQuantity(), $this->VALID_quantity);
	}

	/**
	 * test grabbing a ProductLocation by productId that does not exist
	 **/
	public function testGetInvalidProductLocationByProductId() {
		// grab an productId that does not exist
		$productLocation = ProductLocation::getProductLocationByProductId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($productLocation);
	}
}