<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/movement.php");
require_once(dirname(__DIR__) . "/php/classes/user.php");
require_once(dirname(__DIR__) . "/php/classes/product.php");
require_once(dirname(__DIR__) . "/php/classes/vendor.php");
require_once(dirname(__DIR__) . "/php/classes/location.php");
require_once(dirname(__DIR__) . "/php/classes/unit-of-measure.php");

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
	protected $VALID_fromLocationId = 1;

	/**
	 * invalid fromLocationId to use
	 * @var int $INVALID_fromLocationId
	 **/
	protected $INVALID_fromLocationId = 4294967296;

	/**
	 * valid toLocationId to use
	 * @var int $VALID_toLocationId
	 **/
	protected $VALID_toLocationId = 1;

	/**
	 * invalid toLocationId to use
	 * @var int $INVALID_toLocationId
	 **/
	protected $INVALID_toLocationId = 4294967296;

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
	 * valid userId to use
	 * @var int $VALID_userId
	 **/
	protected $VALID_userId = 1;

	/**
	 * invalid userId to use
	 * @var int $INVALID_userId
	 **/
	protected $INVALID_userId = 4294967296;

	/**
	 * valid cost to use
	 * @var float $VALID_cost
	 **/
	protected $VALID_cost = 3.50;

	/**
	 * invalid cost to use
	 * @var float $INVALID_cost
	 **/
	protected $INVALID_cost = 4.75689;

	/**
	 * valid movementDate to use
	 * @var DateTime $VALID_movementDate
	 **/
	protected $VALID_movementDate = "2015-09-26 08:45:25";

	/**
	 * invalid movementDate to use
	 * @var DateTime $INVALID_movementDate
	 **/
	protected $INVALID_movementDate = "2015/26/09 14:25:50";

	/**
	 * valid movementType to use
	 * @var string $VALID_movementType
	 **/
	protected $VALID_movementType = "TR";

	/**
	 * invalid movementType to use
	 * @var string $INVALID_movementType
	 **/
	protected $INVALID_movementType = "RET";

	/**
	 * valid price to use
	 * @var float $VALID_price
	 **/
	protected $VALID_price = 5.75;

	/**
	 * invalid price to use
	 * @var float $INVALID_price
	 **/
	protected $INVALID_price = 4.75689;


	/**
	 * creating a null User object
	 * for global scope
	 * @var User $user
	 **/
	protected $user = null;

	/**
	 * creating a null Vendor object
	 * for global scope
	 * @var Vendor $vendor
	 **/
	protected $vendor = null;

	/**
	 * creating a null Product object
	 * for global scope
	 * @var Product $product
	 **/
	protected $product = null;

	/**
	 * creating a null fromLocation object
	 * for global scope
	 * @var Location $fromLocation
	 **/
	protected $fromLocation = null;

	/**
	 * creating a null toLocation object
	 * for global scope
	 * @var Location $toLocation
	 **/
	protected $toLocation = null;

	/**
	 * creating a null UnitOfMeasure object
	 * for global scope
	 * @var UnitOfMeasure $unitOfMeasure
	 **/
	protected $unitOfMeasure = null;


	public function setUp() {
		parent::setUp();

		$userId = null;
		$firstName = "Jim";
		$lastName = "Jim";
		$root = "F";
		$addressLineOne = "123 House St.";
		$addressLineTwo = "";
		$city = "Tattoine";
		$state = "AK";
		$zipCode = "52467";
		$email = "jjim@naboomail.nb";
		$phoneNumber = "5052253231";
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$hash = hash_pbkdf2("sha512","password1234", $salt,262144, 128);

		$user = new User($userId, $firstName, $lastName, $root, $addressLineOne, $addressLineTwo, $city, $state, $zipCode, $email, $phoneNumber, $hash, $salt);
		$user->insert($this->getPDO());

		$vendorId = null;
		$name = "TruFork";
		$contactName = "Trevor Rigler";
		$email = "trier@cnm.edu";
		$phoneNumber = "5053594687";

		$vendor = new Vendor($vendorId, $name, $contactName, $email, $phoneNumber);
		$vendor->insert($this->getPDO());

		$productId = null;
		$vendorId = null;
		$description = "A glorius bead to use";
		$leadTime = "10 days";
		$sku = "thtfr354";
		$title = "Bead-Green-Blue-Circular";

		$product = new Product($productId, $vendorId, $description, $leadTime, $sku, $title);
		$product->insert($this->getPDO());

		$locationId = null;
		$description = "Back Stock";
		$storageCode = "BS";

		$fromLocation = new Location($locationId, $vendorId, $description, $storageCode);
		$fromLocation->insert($this->getPDO());

		$locationId = null;
		$description = "Front Stock";
		$storageCode = "FS";

		$toLocation = new Location($locationId, $vendorId, $description, $storageCode);
		$toLocation->insert($this->getPDO());

		$unitId = null;
		$unitCode = "pk";
		$quantity = "10.50";

		$unitOfMeasure = new UnitOfMeasure($unitId, $unitCode, $quantity);
		$unitOfMeasure->insert($this->getPDO());


	}

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
		$this->assertSame($pdoMovement->getFromLocationId(), $this->VALID_fromLocationId);
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
	 * test inserting a Movement and regrabbing it from mySQL		?????????????????????????????????????
	 **/
	public function testGetValidMovementByMovementId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert it into mySQL
		$movement = new Movement(null, $this->VALID_fromLocationId, $this->VALID_toLocationId, $this->VALID_productId, $this->VALID_unitId, $this->VALID_userId, $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByMovementId($this->getPDO(), $movement->getMovementId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
		$this->assertSame($pdoMovement->getFromLocationId(), $this->VALID_fromLocationId);
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
	 * test grabbing a Movement that does not exist
	 **/
	public function testGetInvalidMovementByMovementId() {
		// grab a profile id that exceeds the maximum allowable profile id
		$movement = Movement::getMovementByMovementId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($movement);
	}

	/**
	 * test grabbing a Movement by fromLocationId
	 **/
	public function testGetValidMovementByFromLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->VALID_fromLocationId, $this->VALID_toLocationId, $this->VALID_productId, $this->VALID_unitId, $this->VALID_userId, $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByFromLocationId($this->getPDO(), $movement->getFromLocationId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
		$this->assertSame($pdoMovement->getFromLocationId(), $this->VALID_fromLocationId);
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
	 * test grabbing a Movement by fromLocationId that does not exist
	 **/
	public function testGetInvalidMovementByFromLocationId() {
		// grab an fromLocationId that does not exist
		$movement = Movement::getMovementByFromLocationId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($movement);
	}

	/**
	 * test grabbing a Movement by toLocationId
	 **/
	public function testGetValidMovementByToLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->VALID_fromLocationId, $this->VALID_toLocationId, $this->VALID_productId, $this->VALID_unitId, $this->VALID_userId, $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByToLocationId($this->getPDO(), $movement->getToLocationId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
		$this->assertSame($pdoMovement->getFromLocationId(), $this->VALID_fromLocationId);
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
	 * test grabbing a Movement by toLocationId that does not exist
	 **/
	public function testGetInvalidMovementByToLocationId() {
		// grab an toLocationId that does not exist
		$movement = Movement::getMovementByFromLocationId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($movement);
	}
}