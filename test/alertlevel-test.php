<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/alert-level.php");

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
	protected $VALID_alertId = "69";
	/**
	 * invalid alert id to use
	 * @var int $INVALID_alertId
	 **/
	protected $INVALID_alertId = "4294967296";
	/**
	 * valid alert code to use
	 * @var string $VALID_alertCode
	 **/
	protected $VALID_alertCode = "1";
	/**
	 * valid alert code 2 to use
	 * @var string $VALID_alertCode2
	 **/
	protected $VALID_alertCode2 = "2";
	/**
	 * invalid alert code to use
	 * @var string $INVALID_alertCode
	 **/
	protected $INVALID_alertCode = "123";
	/**
	 * valid alert level to use
	 * @var string $VALID_alertLevel
	 **/
	protected $VALID_alertLevel = "100.321";
	/**
	 * invalid alert level to use
	 * @var string $INVALID_alertLevel
	 **/
	protected $INVALID_alertLevel = "100.3211232";
	/**
	 * valid alert frequency to use
	 * @var string $VALID_vendorFrequency
	 **/
	protected $VALID_alertFrequency = "AB";
	/**
	 * invalid alert frequency to use
	 * @var string $VALID_alertFrequency
	 **/
	protected $INVALID_alertFrequency = "ABC";
	/**
	 * valid alert operator to use
	 * @var string $VALID -alertOperator
	 **/
	protected $VALID_alertOperator = "0";
	/**
	 * second valid notification to use
	 * @var string $VALID_alertOperator
	 **/
	protected $INVALID_alertOperator = "this is only a test";

	/**
	 * test inserting a valid Alert Level and verify that the actual mySQL data matches
	 **/
	public function testInsertValidAlertLevel() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new Alert level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertLevel, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), $alertLevel->getAlertId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
		$this->assertSame($pdoAlertLevel->getAlertId(), $this->VALID_alertId);
		$this->assertSame($pdoAlertLevel->getAlertCode(), $this->VALID_alertCode);
		$this->assertSame($pdoAlertLevel->getAlertFrequency(), $this->VALID_alertFrequency);
		$this->assertSame($pdoAlertLevel->getAlertLevel(), $this->VALID_alertLevel);
		$this->assertSame($pdoAlertLevel->getAlertOperator(), $this->VALID_alertOperator);
	}

	/**
	 * test inserting a Alert Level that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidAlertLevel() {
		// create an AlertLevel with a non null alertId and watch it fail
		$alertLevel = new AlertLevel(DataDesignTest::INVALID_KEY, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertLevel, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());
	}

	/**
	 * test inserting a alertLevel, editing it, and then updating it
	 **/
	public function testUpdateValidAlertLevel() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new Alert Level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertLevel, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// edit the alertLevel and update it in mySQL
		$alertLevel->set($this->VALID_alertCode2);
		$alertLevel->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), $alertLevel->getalertId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
		$this->assertSame($pdoAlertLevel->getAlertId(), $this->VALID_alertId);
		$this->assertSame($pdoAlertLevel->getAlertCode(), $this->VALID_alertCode);
		$this->assertSame($pdoAlertLevel->getAlertFrequency(), $this->VALID_alertFrequency);
		$this->assertSame($pdoAlertLevel->getAlertLevel(), $this->VALID_alertLevel);
		$this->assertSame($pdoAlertLevel->getAlertOperator(), $this->VALID_alertOperator);
	}

	/**
	 * test updating a alert level that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidAlertLevel() {
		//create an Alert Level and try to update it without actually inserting it
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertLevel, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());
	}

	/**
	 * test creating an AlertLevel and then deleting it
	 **/
	public function testDeleteValidAlertLevel() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new Alert Level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertLevel, $this->VALID_alertOperator);
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
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertLevel, $this->VALID_alertOperator);
		$alertLevel->delete($this->getPDO());
	}

	/**
	 * test inserting an Alert Level and regrabbing it from mySQL
	 **/
	public function testGetValidAlertLevelByAlertId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new Alert Level and insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertLevel, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), $alertLevel->getalertId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
		$this->assertSame($pdoAlertLevel->getAlertId(), $this->VALID_alertId);
		$this->assertSame($pdoAlertLevel->getAlertCode(), $this->VALID_alertCode);
		$this->assertSame($pdoAlertLevel->getAlertFrequency(), $this->VALID_alertFrequency);
		$this->assertSame($pdoAlertLevel->getAlertLevel(), $this->VALID_alertLevel);
		$this->assertSame($pdoAlertLevel->getAlertOperator(), $this->VALID_alertOperator);
	}

	/**
	 * test grabbing an Alert Level that does not exist
	 **/
	public function testGetInvalidAlertLevelByAlertId() {
		// grab a alert id that exceeds the maximum allowable alert id
		$alertLevel = AlertLevel::getAlertLevelByAlertId($this->getPDO(), DataDesignTest::INVALID_KEY);
		$this->assertNull($alertLevel);
	}

	/**
	 * test grabbing an AlertLevel by alert code
	 **/
	public function testGetValidAlertLevelByAlertCode() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new alert leveland insert to into mySQL
		$alertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertLevel, $this->VALID_alertOperator);
		$alertLevel->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoAlertLevel = AlertLevel::getAlertLevelByAlertCode($this->getPDO(), $alertLevel->getAlertCode());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("alertLevel"));
		$this->assertSame($pdoAlertLevel->getAlertId(), $this->VALID_alertId);
		$this->assertSame($pdoAlertLevel->getAlertCode(), $this->VALID_alertCode);
		$this->assertSame($pdoAlertLevel->getAlertFrequency(), $this->VALID_alertFrequency);
		$this->assertSame($pdoAlertLevel->getAlertLevel(), $this->VALID_alertLevel);
		$this->assertSame($pdoAlertLevel->getAlertOperator(), $this->VALID_alertOperator);
	}
	/**
	 * test grabbing an AlertLevel that does not exist
	 **/
	public function testGetInvalidAlertLevelByAlertCode(){
		//grab an alert code that does not exist
		$alertLevel = AlertLevel::getAlertLevelByAlertCode($this->getPDO(),"123");
		$this->assertNull($alertLevel);
	}
}