<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");


/**
 * Full PHPUnit test for the Location class
 *
 * This is a complete test for the Location Class. It is complete because *ALL* mySQL/PDO
 * enabled methods are tested for both invalid and valid inputs.
 *
 * @see Location
 * @author Charles Sandidge <sandidgec@gmail.com>
 **/
class LocationTest extends InventoryTextTest {

	/**
	 * Valid locationId
	 * @var int $locationId
	 */
	protected $VALID_locationId = 7;
	/**
	 * valid storageCode
	 * @var string $storageCode
	 **/
	protected $VALID_storageCode = "br";
	/**
	 * valid description of locationId
	 * @var string $description
	 **/
	protected $VALID_description = "back shelf";
	/**
	 * @var Product $product
	 **/
	protected $product = null;
	/**
	 * @var UnitOfMeasure $unitOfMeasure
	 **/
	protected $unitOfMeasure = null;

	/**
 * Set up to create vendor, product, unitOfMeasure objects
 *
 **/
	public function setUp() {
		parent::setUp();

		$vendorId = null;
		$contactName = "Trevor Rigler";
		$vendorEmail = "trier@cnm.edu";
		$vendorName = "TruFork";
		$vendorPhoneNumber = "5053594687";

		$vendor = new Vendor($vendorId, $contactName, $vendorEmail, $vendorName, $vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		$productId = null;
		$vendorId = $vendor->getVendorId();
		$description = "A glorius bead to use";
		$leadTime = 10;
		$sku = "TGT354";
		$title = "Bead-Green-Blue-Circular";

		$this->product = new Product($productId, $vendorId, $description, $leadTime, $sku, $title);
		$this->product->insert($this->getPDO());

		$unitId = null;
		$quantity = 3.5;
		$unitCode = "ea";

		$this->unitOfMeasure = new UnitOfMeasure($unitId, $unitCode, $quantity);
		$this->unitOfMeasure->insert($this->getPDO());
	}
	/**
	 * test inserting a valid Location and verify that the actual mySQL data matches
	 **/
	public function testInsertValidLocation() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertSame($pdoUser->getStorageCode(), $this->VALID_storageCode);
		$this->assertSame($pdoUser->getDescription(), $this->VALID_description);
	}

	/**
	 * test inserting a Location that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidLocation() {
		// create a location with a non null locationId and watch it fail
		$location = new Location(InventoryTextTest::INVALID_KEY, $this->VALID_storageCode, $this->VALID_description);

		$location->insert($this->getPDO());
	}

	/**
	 * test inserting a Location, editing it, and then updating it
	 **/
	public function testUpdateValidLocation() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		$location->insert($this->getPDO());

		// edit the location and update it in mySQL
		$location->setStorageCode($this->VALID_storageCode);
		$location->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertSame($pdoLocation->getStorageCode(), $this->VALID_storageCode);
		$this->assertSame($pdoLocation->getDescription(), $this->VALID_description);

	}

	/**
	 * test updating a Location that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidLocation() {
		// create a Location and try to update it without actually inserting it
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);
		$location->update($this->getPDO());
	}

	/**
	 * test creating a Location and then deleting it
	 **/
	public function testDeleteValidLocation() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);
		$location->insert($this->getPDO());

		// delete the Location from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("location"));
		$location->delete($this->getPDO());

		// grab the data from mySQL and enforce the Location does not exist
		$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertNull($pdoLocation);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("location"));
	}


	/**
	 * test deleting a Location that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidLocation() {
		// create a Location and try to delete it without actually inserting it
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);
		$location->delete($this->getPDO());
	}

	/**
	 * test inserting a Location and regrabbing it from mySQL
	 **/
	public function testGetValidLocationByLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new location and insert to into mySQL
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoLocation = Location::getLocationByLocationId($this->getPDO(), $location->getLocationId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertSame($pdoLocation->getStorageCode(), $this->VALID_storageCode);
		$this->assertSame($pdoLocation->getDescription(), $this->VALID_description);

	}

	/**
	 * test grabbing a Location that does not exist
	 **/
	public function testGetInvalidLocationByLocationId() {
		// grab a location id that exceeds the maximum allowable location id
		$location = Location::getLocationByLocationId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($location);
	}

	/**
	 * test grabbing a location by storageCode
	 **/
	public function testGetValidLocationByStorageCode() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new Location and insert to into mySQL
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);
		$location->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoLocation = Location::getLocationByStorageCode($this->getPDO(), $this->VALID_storageCode);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("location"));
		$this->assertSame($pdoLocation->getStorageCode(), $this->VALID_storageCode);
		$this->assertSame($pdoLocation->getDescription(), $this->VALID_description);

	}

	/**
	 * test grabbing a Location by an storageCode that does not exists
	 **/
	public function testGetInvalidLocationByStorageCode() {
		// grab an storage code that does not exist
		Location::getLocationByStorageCode($this->getPDO(), "does@not.exist");
	}

	/**
	 * test grabbing location by productId
	 **/
	public function testGetValidProductByLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("location");

		// create a new location and insert to into mySQL
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);
		$location->insert($this->getPDO());

		$quantity = 5.9;

		// create a new location and insert to into mySQL
		$productLocation = new productLocation($location->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(),
			$quantity);
		$productLocation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductArray = Location::getProductByLocationId($this->getPDO(), $location->getLocationId());
		for($i = 0; $i < count($pdoProductArray); $i++) {
			if($i === 0) {
				$this->assertSame($pdoProductArray[$i]->getStorageCode(), $this->VALID_storageCode);
				$this->assertSame($pdoProductArray[$i]->getDescription(), $this->VALID_description);
			} else {
				$this->assertSame($pdoProductArray[$i]->getProductId(), $this->product->getProductId());
				$this->assertSame($pdoProductArray[$i]->getVendorId(), $this->product->getVendorId());
				$this->assertSame($pdoProductArray[$i]->getDescription(), $this->product->getDescription());
				$this->assertSame($pdoProductArray[$i]->getSku(), $this->product->getSku());
				$this->assertSame($pdoProductArray[$i]->getTitle(), $this->product->getTitle());
			}
		}
	}

}

