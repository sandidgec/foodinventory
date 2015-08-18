<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Movement API
 *
 * This is a complete PHPUnit test of the Movement API.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Movement/index.php
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class MovementAPITest extends InventoryTextTest {
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
	protected $INVALID_movementDate = null;

	/**
	 * valid movementType to use
	 * @var string $VALID_movementType
	 **/
	protected $VALID_movementType = "TR";

	/**
	 * invalid movementType to use
	 * @var string $INVALID_movementType
	 **/
	protected $INVALID_movementType = "88";

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

		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);
		$this->VALID_movementDate = DateTime::createFromFormat("Y-m-d H:i:s", "2015-09-26 08:45:25");
		$this->INVALID_movementDate = DateTime::createFromFormat("Y-m-d H:i:s", "2015-14-26 06:25:25");

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
	 * Test Getting Valid Movement By MovementId
	 **/
	public function testGetValidMovementByMovementId() {
		// create a new Movement
		$newMovement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$newMovement->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?movementId=' . $newMovement->getMovementId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Invalid Movement By MovementId
	 **/
	public function testGetInvalidMovementByMovementId() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?movementId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Valid Movement By FromLocationId
	 **/
	public function testGetValidMovementByFromLocationId() {
		// create a new Movement
		$newMovement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$newMovement->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?fromLocationId=' . $newMovement->getFromLocationId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Invalid Movement By FromLocationId
	 **/
	public function testGetInvalidMovementByFromLocationId() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?fromLocationId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Valid Movement By ToLocationId
	 **/
	public function testGetValidMovementByToLocationId() {
		// create a new Movement
		$newMovement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$newMovement->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?toLocationId=' . $newMovement->getToLocationId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Invalid Movement By ToLocationId
	 **/
	public function testGetInvalidMovementByToLocationId() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?toLocationId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Valid Movement By ProductId
	 **/
	public function testGetValidMovementByProductId() {
		// create a new Movement
		$newMovement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$newMovement->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?productId=' . $newMovement->getProductId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Invalid Movement By ProductId
	 **/
	public function testGetInvalidMovementByProductId() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?productId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Valid Movement By UserId
	 **/
	public function testGetValidMovementByUserId() {
		// create a new Movement
		$newMovement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$newMovement->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?userId=' . $newMovement->getUserId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Invalid Movement By UserId
	 **/
	public function testGetInvalidMovementByUserId() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?userId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Valid Movement By MovementDate
	 **/
	public function testGetValidMovementByMovementDate() {
		// create a new Movement
		$newMovement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$newMovement->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$angularDate = $this->VALID_movementDate->getTimestamp() * 1000;
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?movementDate=' . $angularDate);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Invalid Movement By MovementDate
	 **/
	public function testGetInvalidMovementByMovementDate() {
		// grab the data from guzzle and enforce the status' match our expectations
		$angularDate = $this->INVALID_movementDate->getTimestamp() * 1000;
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?movementDate=' . $angularDate);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Valid Movement By MovementType
	 **/
	public function testGetValidMovementByMovementType() {
		// create a new Movement
		$newMovement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);
		$newMovement->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?movementType=' . $newMovement->getMovementType());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Getting Invalid Movement By MovementType
	 **/
	public function testGetInvalidMovementByMovementType() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?movementType=' . $this->INVALID_movementType);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}

	/**
	 * Test Posting Valid Movement
	 **/
	public function testPostValidMovement() {
		// create a new Movement
		$newMovement = new Movement(null, $this->fromLocation->getLocationId(), $this->toLocation->getLocationId(), $this->product->getProductId(), $this->unitOfMeasure->getUnitId(), $this->user->getUserId(), $this->VALID_cost, $this->VALID_movementDate, $this->VALID_movementType, $this->VALID_price);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?page=0');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->post('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/', ['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newMovement]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$movement = json_decode($body);
		$this->assertSame(200, $movement->status);
	}
}