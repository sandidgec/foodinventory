<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/movement.php");

/**
 * Full PHPUnit test for the Movement class
 *
 * This is a complete PHPUnit test of the Movement class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Movement
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class MovementTest extends InventoryTextTest {
	/**
	 * valid movementId to use
	 * @var int $VALID_movementId
	 **/
	protected $VALID_movementId = 1;

	/**
	 * invalid movementId to use
	 * @var int $INVALID_movementId
	 **/
	protected $INVALID_movementId = 4294967296;

	/**
	 * valid fromLocationId to use
	 * @var int $VALID_fromLocationId
	 **/
	protected $VALID_fromLocationId = ;

	/**
	 * invalid fromLocationId to use
	 * @var int $INVALID_fromLocationId
	 **/
	protected $INVALID_fromLocationId = 4294967296;

	/**
	 * valid toLocationId to use
	 * @var int $VALID_toLocationId
	 **/
	protected $VALID_toLocationId;

	/**
	 * invalid toLocationId to use
	 * @var int $INVALID_toLocationId
	 **/
	protected $INVALID_toLocationId = 4294967296;

	/**
	 * valid productId to use
	 * @var int $VALID_productId
	 **/
	protected $VALID_productId;

	/**
	 * invalid productId to use
	 * @var int $INVALID_productId
	 **/
	protected $INVALID_productId = 4294967296;

	/**
	 * valid unitId to use
	 * @var int $VALID_unitId
	 **/
	protected $VALID_unitId;

	/**
	 * invalid unitId to use
	 * @var int $INVALID_unitId
	 **/
	protected $INVALID_unitId = 4294967296;

	/**
	 * valid userId to use
	 * @var int $VALID_userId
	 **/
	protected $VALID_userId;

	/**
	 * invalid userId to use
	 * @var int $INVALID_userId
	 **/
	protected $INVALID_userId = 4294967296;

	/**
	 * valid cost to use
	 * @var float $VALID_cost
	 **/
	protected $VALID_cost;

	/**
	 * valid second cost to use
	 * @var float $VALID_cost2
	 **/
	protected $VALID_cost2;

	/**
	 * invalid cost to use
	 * @var float $INVALID_cost
	 **/
	protected $INVALID_cost;

	/**
	 * valid movementDate to use
	 * @var DateTime $VALID_movementDate
	 **/
	protected $VALID_movementDate;

	/**
	 * invalid movementDate to use
	 * @var DateTime $INVALID_movementDate
	 **/
	protected $INVALID_movementDate;

	/**
	 * valid movementType to use
	 * @var string $VALID_movementType
	 **/
	protected $VALID_movementType;

	/**
	 * invalid movementType to use
	 * @var string $INVALID_movementType
	 **/
	protected $INVALID_movementType;

	/**
	 * valid price to use
	 * @var float $VALID_price
	 **/
	protected $VALID_price;

	/**
	 * invalid price to use
	 * @var float $INVALID_price
	 **/
	protected $INVALID_price;

	/**
	 * test inserting a valid Movement and verify that the actual mySQL data matches
	 **/
	public function testInsertValidMovement() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->VALID_fromLocationId, $this->VALID_toLocationId, $this->VALID_productId, $this->VALID_unitId, $this->VALID_userId, $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByMovementId($this->getPDO(), $movement->getMovementId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
		$this->assertSame($pdoMovement->getFormLocationId(), $this->VALID_fromLocationId);
		$this->assertSame($pdoMovement->getToLocationId(), $this->VALID_toLocationId);
		$this->assertSame($pdoMovement->getProductId(), $this->VALID_productId);
		$this->assertSame($pdoMovement->getUnitId(), $this->VALID_unitId);
		$this->assertSame($pdoMovement->getUserId(), $this->VALID_userId);
		$this->assertSame($pdoMovement->getCost(), $this->VALID_cost);
		$this->assertSame($pdoMovement->getMovementDate(), $this->VALID_movementDate);
		$this->assertSame($pdoMovement->getMovementType(), $this->VALID_movementType);
		$this->assertSame($pdoMovement->getPrice(), $this->VALID_price);
	}

	/**
	 * test inserting a Movement that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidMovement() {
		// create a movement with a non null movementId and watch it fail
		$movement = new Movement(InventoryTextTest::INVALID_KEY, $this->INVALID_fromLocationId, $this->INVALID_toLocationId, $this->INVALID_productId, $this->INVALID_unitId, $this->INVALID_userId, $this->INVALID_cost, $this->INVALID_movementDate, $this->INVALID_movementType, $this->INVALID_price);
		$movement->insert($this->getPDO());
	}

	/**
	 * test inserting a Movement and regrabbing it from mySQL
	 **/
	?????????????????????????????????????????????????????????????????????????????????????????????
	public function testGetValidMovementByMovementId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert it into mySQL
		$movement = new Movement(null, $this->VALID_fromLocationId, $this->VALID_toLocationId, $this->VALID_productId, $this->VALID_unitId, $this->VALID_userId, $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertSame($pdoProfile->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoProfile->getPhone(), $this->VALID_PHONE);
	}

	/**
	 * test grabbing a Movement that does not exist
	 **/
	public function testGetInvalidMovementByMovementId() {
		// grab a profile id that exceeds the maximum allowable profile id
		$movement = Movement::getMovementByMovementId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($movement);
	}

	/**
	 * test grabbing a Profile by at handle
	 **/
	public function testGetValidProfileByAtHandle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByAtHandle($this->getPDO(), $this->VALID_ATHANDLE);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertSame($pdoProfile->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoProfile->getPhone(), $this->VALID_PHONE);
	}

	/**
	 * test grabbing a Profile by at handle that does not exist
	 **/
	public function testGetInvalidProfileByAtHandle() {
		// grab an at handle that does not exist
		$profile = Profile::getProfileByAtHandle($this->getPDO(), "@doesnotexist");
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a Profile by email
	 **/
	public function testGetValidProfileByEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_PHONE);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByEmail($this->getPDO(), $this->VALID_EMAIL);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertSame($pdoProfile->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoProfile->getPhone(), $this->VALID_PHONE);
	}

	/**
	 * test grabbing a Profile by an email that does not exists
	 **/
	public function testGetInvalidProfileByEmail() {
		// grab an email that does not exist
		$profile = Profile::getProfileByEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($profile);
	}
}