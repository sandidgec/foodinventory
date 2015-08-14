<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/product-alert.php");
require_once(dirname(__DIR__) . "/php/classes/vendor.php");
require_once(dirname(__DIR__) . "/php/classes/product.php");
require_once(dirname(__DIR__) . "/php/classes/alert-level.php");


/**
 * Full PHPUnit test for the ProductAlert class
 *
 * This is a complete PHPUnit test of the ProductAlert class.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see ProductLocation
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class ProductAlertTest extends InventoryTextTest {
	/**
	 * valid alertEnabled to use
	 * @var boolean $VALID_alertEnabled
	 **/
	protected $VALID_alertEnabled = true;

	/**
	 * valid second alertEnabled to use
	 * @var boolean $VALID_alertEnabled2
	 **/
	protected $VALID_alertEnabled2 = false;

	/**
	 * invalid alertEnabled to use
	 * @var boolean $INVALID_alertEnabled
	 **/
	protected $INVALID_alertEnabled = 01;

	/**
	 * creating a null Product
	 * object for global scope
	 * @var Product $product
	 **/
	protected $product = null;

	/**
	 * creating a null AlertLevel
	 * object for global scope
	 * @var AlertLevel $alertLevel
	 **/
	protected $alertLevel = null;


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

		$alertId = null;
		$alertCode = "WM";
		$alertFrequency = "D2";
		$alertOperator = "L";
		$alertPoint = 100.514;

		$this->alertLevel = new AlertLevel($alertId, $alertCode, $alertFrequency, $alertPoint, $alertOperator);
		$this->alertLevel->insert($this->getPDO());
	}


	/**
	 * test inserting a valid ProductAlert and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProductAlert() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productAlert");

		// create a new ProductAlert and insert to into mySQL
		$productAlert = new ProductAlert($this->alertLevel->getAlertId(), $this->product->getProductId(), $this->VALID_alertEnabled);
		$productAlert->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductAlert = ProductAlert::getProductAlertByAlertIdAndProductId($this->getPDO(), $this->alertLevel->getAlertId(), $this->product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productAlert"));
		$this->assertSame($pdoProductAlert->getAlertId(), $this->alertLevel->getAlertId());
		$this->assertSame($pdoProductAlert->getProductId(), $this->product->getProductId());
		$this->assertSame($pdoProductAlert->isAlertEnabled(), $this->VALID_alertEnabled);
	}

	/**
	 * test inserting a ProductAlert that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductAlert() {
		// create a ProductAlert with a non null alertId and watch it fail
		$productLocation = new ProductAlert(InventoryTextTest::INVALID_KEY, $this->product->getProductId(), $this->VALID_alertEnabled);
		$productLocation->insert($this->getPDO());
	}

	/**
	 * test inserting a ProductAlert, editing it, and then updating it
	 **/
	public function testUpdateValidProductAlert() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productAlert");

		// create a new ProductAlert and insert to into mySQL
		$productAlert = new ProductAlert($this->alertLevel->getAlertId(), $this->product->getProductId(), $this->VALID_alertEnabled);
		$productAlert->insert($this->getPDO());
		// edit the ProductLocation and update it in mySQL
		$productAlert->setAlertEnabled($this->VALID_alertEnabled2);
		$productAlert->update($this->getPDO());
		// grab the data from mySQL and enforce the ProductLocation does not exist
		$pdoProductAlert = ProductAlert::getProductAlertByAlertIdAndProductId($this->getPDO(), $this->alertLevel->getAlertId(), $this->product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productAlert"));
		$this->assertSame($pdoProductAlert->getAlertId(), $this->alertLevel->getAlertId());
		$this->assertSame($pdoProductAlert->getProductId(), $this->product->getProductId());
		$this->assertSame($pdoProductAlert->isAlertEnabled(), $this->VALID_alertEnabled2);
	}

	/**
	 * test updating a ProductAlert that does not exist
	 *
	 **/
	public function testUpdateInvalidProductAlert() {
		// create a Profile and try to update it without actually inserting it
		$productLocation = new ProductAlert(InventoryTextTest::INVALID_KEY, $this->product->getProductId(), $this->VALID_alertEnabled);
		$productLocation->update($this->getPDO());
	}

	/**
	 * test grabbing a ProductAlert by alertId and productId
	 **/
	public function testGetValidProductLocationByAlertIdAndProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productAlert");

		// create a new ProductAlert and insert to into mySQL
		$productAlert = new ProductAlert($this->alertLevel->getAlertId(), $this->product->getProductId(), $this->VALID_alertEnabled);
		$productAlert->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductAlert = ProductAlert::getProductAlertByAlertIdAndProductId($this->getPDO(), $this->alertLevel->getAlertId(), $this->product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productAlert"));
		$this->assertSame($pdoProductAlert->getAlertId(), $this->alertLevel->getAlertId());
		$this->assertSame($pdoProductAlert->getProductId(), $this->product->getProductId());
		$this->assertSame($pdoProductAlert->isAlertEnabled(), $this->VALID_alertEnabled);
	}

	/**
	 * test grabbing a ProductAlert by alertId and productId that does not exist
	 *
	 * PDOException
	 **/
	public function testGetInvalidProductLocationByAlertIdAndProductId() {
		// grab an alertId that does not exist
		$pdoProductAlert = ProductAlert::getProductAlertByAlertIdAndProductId($this->getPDO(), InventoryTextTest::INVALID_KEY, $this->product->getProductId());
			$this->assertNull($pdoProductAlert);

	}

	/**
	 * test grabbing a ProductAlert by alertId
	 **/
	public function testGetValidProductLocationByAlertId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productAlert");

		// create a new ProductAlert and insert to into mySQL
		$productAlert = new ProductAlert($this->alertLevel->getAlertId(), $this->product->getProductId(), $this->VALID_alertEnabled);
		$productAlert->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductAlert = ProductAlert::getProductAlertByAlertId($this->getPDO(), $this->alertLevel->getAlertId());
		foreach($pdoProductAlert as $pdoPA) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productAlert"));
			$this->assertSame($pdoPA->getAlertId(), $this->alertLevel->getAlertId());
			$this->assertSame($pdoPA->getProductId(), $this->product->getProductId());
			$this->assertSame($pdoPA->isAlertEnabled(), $this->VALID_alertEnabled);
		}
	}

	/**
	 * test grabbing a ProductAlert by alertId that does not exist
	 *
	 * PDOException
	 **/
	public function testGetInvalidProductLocationByAlertId() {
		// grab an alertId that does not exist
		$pdoProductAlert = ProductAlert::getProductAlertByAlertId($this->getPDO(), InventoryTextTest::INVALID_KEY);
			$this->assertNull($pdoProductAlert);
	}

	/**
	 * test grabbing a ProductAlert by productId
	 **/
	public function testGetValidProductAlertByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productAlert");

		// create a new ProductAlert and insert to into mySQL
		$productAlert = new ProductAlert($this->alertLevel->getAlertId(), $this->product->getProductId(), $this->VALID_alertEnabled);
		$productAlert->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductAlert = ProductAlert::getProductAlertByProductId($this->getPDO(), $this->product->getProductId());
		foreach($pdoProductAlert as $pdoPA) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productAlert"));
			$this->assertSame($pdoPA->getAlertId(), $this->alertLevel->getAlertId());
			$this->assertSame($pdoPA->getProductId(), $this->product->getProductId());
			$this->assertSame($pdoPA->isAlertEnabled(), $this->VALID_alertEnabled);
		}
	}

	/**
	 * test grabbing a ProductAlert by productId that does not exist
	 *
	 * PDOException
	 **/
	public function testGetInvalidProductAlertByProductId() {
		// grab an productId that does not exist
		$pdoProductAlert = ProductAlert::getProductAlertByProductId($this->getPDO(), InventoryTextTest::INVALID_KEY);
			$this->assertNull($pdoProductAlert);
	}

	/**
	 * test grabbing a ProductAlert by alertEnabled
	 **/
	public function testGetValidProductAlertByAlertEnabled() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productAlert");

		// create a new ProductAlert and insert to into mySQL
		$productAlert = new ProductAlert($this->alertLevel->getAlertId(), $this->product->getProductId(), $this->VALID_alertEnabled);
		$productAlert->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductAlert = ProductAlert::getProductAlertByAlertEnabled($this->getPDO(), $productAlert->isAlertEnabled());
		foreach($pdoProductAlert as $pdoPA) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("productAlert"));
			$this->assertSame($pdoPA->getAlertId(), $this->alertLevel->getAlertId());
			$this->assertSame($pdoPA->getProductId(), $this->product->getProductId());
			$this->assertSame($pdoPA->isAlertEnabled(), $this->VALID_alertEnabled);
		}
	}

	/**
	 * test grabbing a ProductAlert by alertEnabled that does not exist
	 *
	 * PDOException
	 **/
	public function testGetInvalidProductAlertByAlertEnabled() {
		// grab an alertEnabled that does not exist
		$pdoProductAlert = ProductAlert::getProductAlertByAlertEnabled($this->getPDO(), $this->INVALID_alertEnabled);
			$this->assertNull($pdoProductAlert);
	}
}