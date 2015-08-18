<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");


/**
 * Full PHPUnit test for the Location class api
 *
 * This is a test of the api for the location class
 * enabled methods are tested for both invalid and valid inputs.
 *
 * @see Location/index
 * @author Charles Sandidge <sandidgec@gmail.com>
 **/
class LocationAPITest extends InventoryTextTest {

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
	 * set up for guzzle/cookies
	 */
	public function setUp() {
		parent::setUp();

		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);
	}


	/**
	 * Test Deleting a Valid Location
	 **/
	public function testDeleteValidLocation() {
		// create a new Location
		$newLocation = new Location(null,$this->VALID_storageCode, $this->VALID_description);

		$newLocation->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/');
		$response = $this->guzzle->delete('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/' . $newLocation->getLocationId(), ['headers' =>
			['X-XSRF-TOKEN' => $this->getXsrfToken()]]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$location = json_decode($body);
		$this->assertSame(200, $location->status);
	}

	/**
	 * Test grabbing Valid Location by Location Id
	 **/
	public function testGetValidLocationByLocationId() {
		// create a new Location
		$newLocation = new Location(null,$this->VALID_storageCode, $this->VALID_description);

		$newLocation->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/?locationId=' . $newLocation->getLocationId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$location = json_decode($body);
		$this->assertSame(200, $location->status);
	}

	/**
	 * Test grabbing Valid Location by Valid Storage Code
	 **/
	public function testGetValidLocationByValidStorageCode() {
		// create a new Location
		$newLocation = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		$newLocation->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/?storageCode=' . $newLocation->getStorageCode());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$location = json_decode($body);
		$this->assertSame(200, $location->status);
	}


	/**
	 * Test Get All Locations
	 **/
	public function testGetAllLocations() {
		// create a new Location
		$newLocation = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		$newLocation->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/');
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$location = json_decode($body);
		$this->assertSame(200, $location->status);
	}

	/**
	 * test ability to Post valid location
	 **/
	public function testPostValidLocation() {
		// create a new Location
		$newLocation = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/?storageCode=br');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->post('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/',['headers' =>
			['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newLocation]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$location = json_decode($body);
		echo $body . PHP_EOL;
		$this->assertSame(200, $location->status);
	}

	/**
	 * test ability to Put valid location
	 **/
	public function testPutValidLocation() {
		// create a new Location
		$newLocation = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/' . $newLocation->getLocationId(),['headers' =>
			['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newLocation]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$location = json_decode($body);
		echo $body . PHP_EOL;
		$this->assertSame(200, $location->status);
	}
}
