<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

	/**
	 * Full PHPUnit test for the alert level class
	 *
	 * This is a complete PHPUnit test of the Alert Level class. It is complete because *ALL* mySQL/PDO enabled methods
	 * are tested for both invalid and valid inputs.
	 *
	 * @see alert-level
	 * @author James Huber <jhuber8@cnm.edu>
	 **/
class AlertLevelTest extends InventoryTextTest {
	/**
	 * valid at alert id to use
	 * @var int $VALID_alertId
	 **/
	protected $VALID_alertId = 69;
	/**
	 * invalid alert id to use
	 * @var int $INVALID_alertId
	 **/
	protected $INVALID_alertId = "ASC";
	/**
	 * valid alert code to use
	 * @var string $VALID_alertCode
	 **/
	protected $VALID_alertCode = "A6";
	/**
	 * valid alert code 2 to use
	 * @var string $VALID_alertCode2
	 **/
	protected $VALID_alertCode2 = "B6";
	/**
	 * invalid alert code to use
	 * @var string $INVALID_alertCode
	 **/
	protected $INVALID_alertCode = 123456;
	/**
	 * valid alert level to use
	 * @var string $VALID_alertLevel
	 **/
	protected $VALID_alertPoint = 100.321;
	/**
	 * invalid alert level to use
	 * @var string $INVALID_alertLevel
	 **/
	protected $INVALID_alertPoint = 100.3211232;
	/**
	 * valid alert frequency to use
	 * @var string $VALID_vendorFrequency
	 **/
	protected $VALID_alertFrequency = "A";
	/**
	 * invalid alert frequency to use
	 * @var string $VALID_alertFrequency
	 **/
	protected $INVALID_alertFrequency = "ABC";
	/**
	 * valid alert operator to use
	 * @var string $VALID_alertOperator
	 **/
	protected $VALID_alertOperator = "a";

	/**
	 * creating a null Product
	 * object for global scope
	 * @var Product $product
	 **/
	protected $product = null;

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
	}

	/**
	 * test inserting a valid Alert Level and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAlertLevel() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new Alert level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), $alertLevel->getAlertId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
		$this->assertSame($pdoAlertLevel->getAlertCode(), $this->VALID_alertCode);
		$this->assertSame($pdoAlertLevel->getAlertFrequency(), $this->VALID_alertFrequency);
		$this->assertSame($pdoAlertLevel->getAlertPoint(), $this->VALID_alertPoint);
		$this->assertSame($pdoAlertLevel->getAlertOperator(), $this->VALID_alertOperator);
	}

	/**
	 * test inserting a Alert Level that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidAlertLevel() {
		// create an AlertLevel with a non null alertId and watch it fail
		$alertLevel = new AlertLevel(InventoryTextTest::INVALID_KEY, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());
	}

	/**
	 * test inserting a alertLevel, editing it, and then updating it
	 **/
	public function testUpdateValidAlertLevel() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new Alert Level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// edit the alertLevel and update it in mySQL
		$alertLevel->setAlertCode($this->VALID_alertCode2);
		$alertLevel->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), $alertLevel->getalertId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
		$this->assertSame($pdoAlertLevel->getAlertCode(), $this->VALID_alertCode2);
		$this->assertSame($pdoAlertLevel->getAlertFrequency(), $this->VALID_alertFrequency);
		$this->assertSame($pdoAlertLevel->getAlertPoint(), $this->VALID_alertPoint);
		$this->assertSame($pdoAlertLevel->getAlertOperator(), $this->VALID_alertOperator);
	}

	/**
	 * test updating a alert level that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidAlertLevel() {
		//create an Alert Level and try to update it without actually inserting it
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->update($this->getPDO());
	}

	/**
	 * test creating an AlertLevel and then deleting it
	 **/
	public function testDeleteValidAlertLevel() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new Alert Level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// delete the Vendor from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
		$alertLevel->delete($this->getPDO());

		// grab the data from mySQL and enforce the AlertLevel does not exist
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), $alertLevel->getalertId());
		$this->assertNull($pdoAlertLevel);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("alertLevel"));
	}

	/**
	 * test deleting a alertLevel that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidAlertLevel() {
		// create an AlertLevel and try to delete it without actually inserting it
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->delete($this->getPDO());
	}

	/**
	 * test inserting an Alert Level and regrabbing it from mySQL
	 **/
	public function testGetValidAlertLevelByAlertId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new Alert Level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), $alertLevel->getalertId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
		$this->assertSame($pdoAlertLevel->getAlertCode(), $this->VALID_alertCode);
		$this->assertSame($pdoAlertLevel->getAlertFrequency(), $this->VALID_alertFrequency);
		$this->assertSame($pdoAlertLevel->getAlertPoint(), $this->VALID_alertPoint);
		$this->assertSame($pdoAlertLevel->getAlertOperator(), $this->VALID_alertOperator);
	}

	/**
	 * test grabbing an Alert Level that does not exist
	 **/
	public function testGetInvalidAlertLevelByAlertId() {
		// grab a alert id that exceeds the maximum allowable alert id
		$alertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($alertLevel);
	}

	/**
	 * test grabbing an AlertLevel by alert code
	 **/
	public function testGetValidAlertLevelByAlertCode() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new alert level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertCode($this->getPDO(), $alertLevel->getAlertCode());
		foreach($pdoAlertLevel as $al) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
			$this->assertSame($al->getAlertCode(), $this->VALID_alertCode);
			$this->assertSame($al->getAlertFrequency(), $this->VALID_alertFrequency);
			$this->assertSame($al->getAlertPoint(), $this->VALID_alertPoint);
			$this->assertSame($al->getAlertOperator(), $this->VALID_alertOperator);
		}
	}

	/**
	 * test grabbing an AlertLevel that does not exist
	 **/
	public function testGetInvalidAlertLevelByAlertCode(){
		//grab an alert code that does not exist
		$alertLevel = AlertLevel::getAlertLevelByAlertCode($this->getPDO(), $this->INVALID_alertCode);
		foreach($alertLevel as $al){
			$this->assertNull($al);
		}
	}

	/**
	 * test grabbing an AlertLevel by alert code
	 **/
	public function testGetValidProductByAlertId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new alert level and insert to into mySQL
		$alertLevel = new AlertLevel(null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// create a new alert level and insert to into mySQL
		$productAlert = new productAlert($alertLevel->getAlertId(), $this->product->getProductId(), true);
		$productAlert->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductArray = AlertLevel::getProductByAlertId($this->getPDO(), $alertLevel->getAlertId());
		for($i = 0; $i < count($pdoProductArray); $i++) {
			if($i === 0) {
				$this->assertSame($pdoProductArray[$i]->getAlertCode(), $this->VALID_alertCode);
				$this->assertSame($pdoProductArray[$i]->getAlertFrequency(), $this->VALID_alertFrequency);
				$this->assertSame($pdoProductArray[$i]->getAlertPoint(), $this->VALID_alertPoint);
				$this->assertSame($pdoProductArray[$i]->getAlertOperator(), $this->VALID_alertOperator);
			} else {
				$this->assertSame($pdoProductArray[$i]->getProductId(), $this->product->getProductId());
				$this->assertSame($pdoProductArray[$i]->getVendorId(), $this->product->getVendorId());
				$this->assertSame($pdoProductArray[$i]->getDescription(), $this->product->getDescription());
				$this->assertSame($pdoProductArray[$i]->getSku(), $this->product->getSku());
				$this->assertSame($pdoProductArray[$i]->getTitle(), $this->product->getTitle());
			}
		}
	}

	/**
	 * test grabbing all AlertLevels
	 **/
	public function testGetValidAllAlertLevels() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new alert level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAllAlertLevels($this->getPDO());
		foreach($pdoAlertLevel as $al) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
			$this->assertSame($al->getAlertCode(), $this->VALID_alertCode);
			$this->assertSame($al->getAlertFrequency(), $this->VALID_alertFrequency);
			$this->assertSame($al->getAlertPoint(), $this->VALID_alertPoint);
			$this->assertSame($al->getAlertOperator(), $this->VALID_alertOperator);
		}
	}
}