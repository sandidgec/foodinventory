<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/movement.php");
require_once(dirname(__DIR__) . "/php/classes/user.php");
require_once(dirname(__DIR__) . "/php/classes/vendor.php");
require_once(dirname(__DIR__) . "/php/classes/product.php");
require_once(dirname(__DIR__) . "/php/classes/location.php");
require_once(dirname(__DIR__) . "/php/classes/unit-of-measure.php");

/**
 * Full PHPUnit test for the Movement class
 *
 * This is a complete PHPUnit test of the Movement class.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Movement
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class MovementTest extends InventoryTextTest {
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
	protected $VALID_movementDate = null;

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
	 * creating a null fromLocation
	 * object for global scope
	 * @var Location $fromLocation
	 **/
	protected $fromLocation = null;

	/**
	 * creating a null toLocation
	 * object for global scope
	 * @var Location $toLocation
	 **/
	protected $toLocation = null;

	/**
	 * creating a null Product
	 * object for global scope
	 * @var Product $product
	 **/
	protected $product = null;

	/**
	 * creating a null UnitOfMeasure
	 * object for global scope
	 * @var UnitOfMeasure $unitOfMeasure
	 **/
	protected $unitOfMeasure = null;

	/**
	 * creating a null User
	 * object for global scope
	 * @var User $user
	 **/
	protected $user = null;


	public function setUp() {
		parent::setUp();

		$this->VALID_movementDate = DateTime::createFromFormat("Y-m-d H:i:s", "2015-09-26 08:45:25");

		$userId = null;
		$firstName = "Jim";
		$lastName = "Jim";
		$root = 1;
		$attention = "Urgent: ";
		$addressLineOne = "123 House St.";
		$addressLineTwo = "P.O Box. 9965";
		$city = "Tattoine";
		$state = "AK";
		$zipCode = "52467";
		$email = "jim@naboomail.nb";
		$phoneNumber = "5052253231";
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$hash = hash_pbkdf2("sha512","password1234", $salt,262144, 128);

		$this->user = new User($userId, $lastName, $firstName, $root, $attention, $addressLineOne, $addressLineTwo, $city, $state, $zipCode, $email, $phoneNumber, $salt, $hash);
		$this->user->insert($this->getPDO());

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

		$locationId = null;
		$description = "Back Stock";
		$storageCode = 13;

		$this->fromLocation = new Location($locationId, $storageCode, $description);
		$this->fromLocation->insert($this->getPDO());

		$locationId = null;
		$description = "Front Stock";
		$storageCode = 12;

		$this->toLocation = new Location($locationId, $storageCode, $description);
		$this->toLocation->insert($this->getPDO());

		$unitId = null;
		$unitCode = "pk";
		$quantity = 10.50;

		$this->unitOfMeasure = new UnitOfMeasure($unitId, $unitCode, $quantity);
		$this->unitOfMeasure->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Movement and verify that the actual mySQL data matches
	 **/
	public function testInsertValidMovement() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByMovementId($this->getPDO(), $movement->getMovementId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
		$this->assertSame($pdoMovement->getFromLocationId(), $this->fromLocation->getLocationId());
		$this->assertSame($pdoMovement->getToLocationId(), $this->toLocation->getLocationId());
		$this->assertSame($pdoMovement->getProductId(), $this->product->getProductId());
		$this->assertSame($pdoMovement->getUnitId(), $this->unitOfMeasure->getUnitId());
		$this->assertSame($pdoMovement->getUserId(), $this->user->getUserId());
		$this->assertSame($pdoMovement->getCost(), $this->VALID_cost);
		$this->assertEquals($pdoMovement->getMovementDate(), $this->VALID_movementDate);
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
		$movement = new Movement(InventoryTextTest::INVALID_KEY, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());
	}

	/**
	 * test grabbing a Movement that does not exist
	 **/
	public function testGetInvalidMovementByMovementId() {
		// grab a movementId that exceeds the maximum allowable movementId
		$movement = Movement::getMovementByMovementId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($movement);
	}

	/**
	 * test inserting and grabbing a Movement with a null movementDate
	 **/
	public function testInsertValidMovementWithNullMovementDate() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, null, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByMovementId($this->getPDO(), $movement->getMovementId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
		$this->assertSame($pdoMovement->getFromLocationId(), $this->fromLocation->getLocationId());
		$this->assertSame($pdoMovement->getToLocationId(), $this->toLocation->getLocationId());
		$this->assertSame($pdoMovement->getProductId(), $this->product->getProductId());
		$this->assertSame($pdoMovement->getUnitId(), $this->unitOfMeasure->getUnitId());
		$this->assertSame($pdoMovement->getUserId(), $this->user->getUserId());
		$this->assertSame($pdoMovement->getCost(), $this->VALID_cost);
		$this->assertInstanceOf('DateTime', $pdoMovement->getMovementDate());
		$this->assertSame($pdoMovement->getMovementType(), $this->VALID_movementType);
		$this->assertSame($pdoMovement->getPrice(), $this->VALID_price);
	}

	/**
	 * test grabbing a Movement by fromLocationId
	 **/
	public function testGetValidMovementByFromLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByFromLocationId($this->getPDO(), $movement->getFromLocationId());
		foreach($pdoMovement as $pdoM) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
			$this->assertSame($pdoM->getFromLocationId(), $this->fromLocation->getLocationId());
			$this->assertSame($pdoM->getToLocationId(), $this->toLocation->getLocationId());
			$this->assertSame($pdoM->getProductId(), $this->product->getProductId());
			$this->assertSame($pdoM->getUnitId(), $this->unitOfMeasure->getUnitId());
			$this->assertSame($pdoM->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoM->getCost(), $this->VALID_cost);
			$this->assertEquals($pdoM->getMovementDate(), $this->VALID_movementDate);
			$this->assertSame($pdoM->getMovementType(), $this->VALID_movementType);
			$this->assertSame($pdoM->getPrice(), $this->VALID_price);
		}
	}

	/**
	 * test grabbing a Movement by fromLocationId that does not exist
	 **/
	public function testGetInvalidMovementByFromLocationId() {
		// grab an fromLocationId that does not exist
		$pdoMovement = Movement::getMovementByFromLocationId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		foreach($pdoMovement as $pdoM) {
			$this->assertNull($pdoM);
		}
	}

	/**
	 * test grabbing a Movement by toLocationId
	 **/
	public function testGetValidMovementByToLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByToLocationId($this->getPDO(), $movement->getToLocationId());
		foreach($pdoMovement as $pdoM) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
			$this->assertSame($pdoM->getFromLocationId(), $this->fromLocation->getLocationId());
			$this->assertSame($pdoM->getToLocationId(), $this->toLocation->getLocationId());
			$this->assertSame($pdoM->getProductId(), $this->product->getProductId());
			$this->assertSame($pdoM->getUnitId(), $this->unitOfMeasure->getUnitId());
			$this->assertSame($pdoM->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoM->getCost(), $this->VALID_cost);
			$this->assertEquals($pdoM->getMovementDate(), $this->VALID_movementDate);
			$this->assertSame($pdoM->getMovementType(), $this->VALID_movementType);
			$this->assertSame($pdoM->getPrice(), $this->VALID_price);
		}
	}

	/**
	 * test grabbing a Movement by toLocationId that does not exist
	 **/
	public function testGetInvalidMovementByToLocationId() {
		// grab an toLocationId that does not exist
		$pdoMovement = Movement::getMovementByToLocationId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		foreach($pdoMovement as $pdoM) {
			$this->assertNull($pdoM);
		}
	}

	/**
	 * test grabbing a Movement by fromLocationId & toLocationId
	 **/
	public function testGetValidMovementByFromLocationIdAndToLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByFromLocationIdAndToLocationId($this->getPDO(), $movement->getFromLocationId(), $movement->getToLocationId());
		foreach($pdoMovement as $pdoM) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
			$this->assertSame($pdoM->getFromLocationId(), $this->fromLocation->getLocationId());
			$this->assertSame($pdoM->getToLocationId(), $this->toLocation->getLocationId());
			$this->assertSame($pdoM->getProductId(), $this->product->getProductId());
			$this->assertSame($pdoM->getUnitId(), $this->unitOfMeasure->getUnitId());
			$this->assertSame($pdoM->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoM->getCost(), $this->VALID_cost);
			$this->assertEquals($pdoM->getMovementDate(), $this->VALID_movementDate);
			$this->assertSame($pdoM->getMovementType(), $this->VALID_movementType);
			$this->assertSame($pdoM->getPrice(), $this->VALID_price);
		}
	}

	/**
	 * test grabbing a Movement by fromLocationId & toLocationId that does not exist
	 **/
	public function testGetInvalidMovementByFromLocationIdAndToLocationId() {
		// grab an fromLocationId & toLocationId that does not exist
		$pdoMovement = Movement::getMovementByToLocationId($this->getPDO(), InventoryTextTest::INVALID_KEY, InventoryTextTest::INVALID_KEY);
		foreach($pdoMovement as $pdoM) {
			$this->assertNull($pdoM);
		}
	}

	/**
	 * test grabbing a Movement by productId
	 **/
	public function testGetValidMovementByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByProductId($this->getPDO(), $movement->getProductId());
		foreach($pdoMovement as $pdoM) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
			$this->assertSame($pdoM->getFromLocationId(), $this->fromLocation->getLocationId());
			$this->assertSame($pdoM->getToLocationId(), $this->toLocation->getLocationId());
			$this->assertSame($pdoM->getProductId(), $this->product->getProductId());
			$this->assertSame($pdoM->getUnitId(), $this->unitOfMeasure->getUnitId());
			$this->assertSame($pdoM->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoM->getCost(), $this->VALID_cost);
			$this->assertEquals($pdoM->getMovementDate(), $this->VALID_movementDate);
			$this->assertSame($pdoM->getMovementType(), $this->VALID_movementType);
			$this->assertSame($pdoM->getPrice(), $this->VALID_price);
		}
	}

	/**
	 * test grabbing a Movement by productId that does not exist
	 **/
	public function testGetInvalidMovementByProductId() {
		// grab an productId that does not exist
		$pdoMovement = Movement::getMovementByProductId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		foreach($pdoMovement as $pdoM) {
			$this->assertNull($pdoM);
		}
	}

	/**
	 * test grabbing a Movement by userId
	 **/
	public function testGetValidMovementByUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("movement");

		// create a new Movement and insert to into mySQL
		$movement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$movement->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoMovement = Movement::getMovementByUserId($this->getPDO(), $movement->getUserId());
		foreach($pdoMovement as $pdoM) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("movement"));
			$this->assertSame($pdoM->getFromLocationId(), $this->fromLocation->getLocationId());
			$this->assertSame($pdoM->getToLocationId(), $this->toLocation->getLocationId());
			$this->assertSame($pdoM->getUnitId(), $this->unitOfMeasure->getUnitId());
			$this->assertSame($pdoM->getUserId(), $this->user->getUserId());
			$this->assertSame($pdoM->getCost(), $this->VALID_cost);
			$this->assertEquals($pdoM->getMovementDate(), $this->VALID_movementDate);
			$this->assertSame($pdoM->getMovementType(), $this->VALID_movementType);
			$this->assertSame($pdoM->getPrice(), $this->VALID_price);
		}
	}

	/**
	 * test grabbing a Movement by userId that does not exist
	 **/
	public function testGetInvalidMovementByUserId() {
		// grab an userId that does not exist
		$pdoMovement = Movement::getMovementByUserId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		foreach($pdoMovement as $pdoM) {
			$this->assertNull($pdoM);
		}
	}

}