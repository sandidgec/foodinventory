<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/location.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");


/**
 * Full PHPUnit test for the Location class api
 *
 * This is a test of the api for the location class
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


	public function setUp() {
		parent::setUp();

		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);
	}


	/**
	 * Test Deleting a Valid Location
	 **/
	public function testDeleteValidLocation() {
		// create a new Location
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->delete('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/delete');
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$object = json_decode($body);
		$this->assertNull($object->status);

		// delete User from mySQL
		$location->delete($this->getPDO());
	}

	/**
	 * Test grabbing Valid Location by Location Id
	 **/
	public function testGetValidLocationByLocationId() {
		// create a new Location
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/?locationId=' . $location->getLocationId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$object = json_decode($body);
		$this->assertSame(200, $object->status);
	}

	/**
	 * Test grabbing Valid Location by Valid Storage Code
	 **/
	public function testGetValidLocationByValidStorageCode() {
		// create a new Location
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/?storageCode=' . $location->getStorageCode());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$object = json_decode($body);
		$this->assertSame(200, $object->status);
	}


	/**
	 * Test Get All Locations
	 **/
	public function testGetAllLocations() {
		// create a new Location
		$location = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		$location->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/?');
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$object = json_decode($body);
		$this->assertSame(200, $object->status);
	}

	public function testPostValidLocation() {
		// create a new Location
		$newLocation = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/?locationId=1');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->post('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/',['headers' =>
			['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newLocation]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$location = json_decode($body);
		$this->assertSame(200, $location->status);
	}

	public function testPutValidLocation() {
		// create a new Location
		$newLocation = new Location(null, $this->VALID_storageCode, $this->VALID_description);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/?locationId=1');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/location/',['headers' =>
			['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newLocation]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$location = json_decode($body);
		$this->assertSame(200, $location->status);
	}
}
