<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");


/**
 * Full PHPUnit test for the User class api
 *
 * This is a test of the api for the user class
 * enabled methods are tested for both invalid and valid inputs.
 *
 * @see User/index
 * @author Charles Sandidge <sandidgec@gmail.com>
 **/
class UserAPITest extends InventoryTextTest {

	/**
	 * Valid userId
	 * @var int
	 */
	protected $VALID_userId = "7";
	/**
	 * valid lastName of userId
	 * @var string $lastName
	 **/
	protected $VALID_lastName = "sandidge";
	/**
	 * valid firstName of userId
	 * @var string $firstName
	 **/
	protected $VALID_firstName = "charles";
	/**
	 * valid root user level
	 * @var boolean $root
	 */
	protected $VALID_root = TRUE;
	/**
	 * valid attention line
	 * @var string $attention ;
	 */
	protected $VALID_attention = "for mr. roboto";
	/**
	 * valid address line 1
	 * @var string $addressLineOne
	 */
	protected $VALID_addressLineOne = "7383 San Diego Dr.";
	/**
	 * valid address line 2
	 * @var string $addressLineTwo ;
	 */
	protected $VALID_addressLineTwo = "Suite 42939";
	/**
	 * valid City
	 * @var string $city
	 */
	protected $VALID_city = "San Diego";
	/**
	 * valid state
	 * @var string $state
	 */
	protected $VALID_state = "CA";
	/**
	 * valid ZipCode
	 * @var int $zipCode ;
	 */
	protected $VALID_zipCode = "92104";
	/**
	 * valid email of userId
	 * @var string $email
	 **/
	protected $VALID_email = "topher@mindyobiz.com";
	/**
	 * valid email 2
	 * @var string $email2
	 */
	protected $VALID_email2 = "tophersotheremail@mindurbiz.com";
	/**
	 * Invalid Email string
	 * @var string
	 */
	protected $INVALID_email = "akddi@topher";
	/**
	 * valid phoneNumber of userId
	 * @var int $phoneNumber
	 **/
	protected $VALID_phoneNumber = "5055551212";
	/**
	 * valid password salt for userId;
	 * @var string $passwordSalt
	 */
	protected $VALID_salt;
	/**
	 * valid password hash for userId;
	 * @var string $passwordHash
	 **/
	protected $VALID_hash;
	/**
	 * @var guzzle
	 **/
	protected $guzzle = null;


	/**
	 * Set up for Salt and Hash as well as guzzle/cookies
	 **/
	public function setUp() {
		parent::setUp();

		$this->VALID_salt = bin2hex(openssl_random_pseudo_bytes(32));
		$this->VALID_hash = hash_pbkdf2("sha512", "password1234", $this->VALID_salt, 262144, 128);
		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);
	}


	/**
	 * Test Deleting a Valid User
	 **/
	public function testDeleteValidUser() {
		// create a new User
		$newUser = new User(null,$this->VALID_lastName, $this->VALID_firstName, $this->VALID_root, $this->VALID_attention,
			$this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city, $this->VALID_state,
			$this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_salt, $this->VALID_hash);

		$newUser->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/');
		$response = $this->guzzle->delete('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/', ['headers' =>
			['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newUser->getUserId()]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$object = json_decode($body);
		$this->assertNull($object->status);
	}

	/**
	 * Test grabbing Valid User by User Id
	 **/
	public function testGetValidUserByUserId() {
		// create a new User
		$newUser = new User(null,$this->VALID_lastName, $this->VALID_firstName, $this->VALID_root, $this->VALID_attention,
			$this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city, $this->VALID_state,
			$this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_salt, $this->VALID_hash);

		$newUser->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/?userId=' . $newUser->getUserId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$user = json_decode($body);
		echo $body . PHP_EOL;
		$this->assertSame(200, $user->status);
	}

	/**
	 * Test grabbing Valid User by Valid Email
	 **/
	public function testGetValidUserByValidEmail() {
		// create a new User
		$newUser = new User(null,$this->VALID_lastName, $this->VALID_firstName, $this->VALID_root, $this->VALID_attention,
			$this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city, $this->VALID_state,
			$this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_salt, $this->VALID_hash);

		$newUser->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/?email=' . $newUser->getEmail());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$user = json_decode($body);
		$this->assertSame(200, $user->status);
	}

	/**
	 *  test grabbing User by Invalid Email
	 **/
	public function testGetValidUserByInvalidEmail() {
		// create a new User
		$newUser = new User(null,$this->VALID_lastName, $this->VALID_firstName, $this->VALID_root, $this->VALID_attention,
			$this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city, $this->VALID_state,
			$this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_salt, $this->VALID_hash);

		$newUser->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/?email=' . $this->INVALID_email);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$user = json_decode($body);
		$this->assertSame(200, $user->status);
	}

	/**
	 * Test Get All Users
	 **/
	public function testGetAllUsers() {
		// create a new User
		$newUser = new User(null,$this->VALID_lastName, $this->VALID_firstName, $this->VALID_root, $this->VALID_attention,
			$this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city, $this->VALID_state,
			$this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_salt, $this->VALID_hash);

		$newUser->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/');
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$user = json_decode($body);
		$this->assertSame(200, $user->status);
	}

	/**
	 * test ability to Post valid user
	 **/
	public function testPostValidUser() {
		// create a new User
		$newUser = new User(null, $this->VALID_lastName, $this->VALID_firstName, $this->VALID_root, $this->VALID_attention,
			$this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city, $this->VALID_state,
			$this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_salt, $this->VALID_hash);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->post('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/',['headers' =>
		['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newUser]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$user = json_decode($body);
		$this->assertSame(200, $user->status);
	}

	/**
	 * test ability to Put valid user
	 **/
	public function testPutValidUser() {
		// create a new User
		$newUser = new User(null, $this->VALID_lastName, $this->VALID_firstName, $this->VALID_root, $this->VALID_attention,
			$this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city, $this->VALID_state,
			$this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_salt, $this->VALID_hash);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/',['headers' =>
			['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newUser]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$user = json_decode($body);
		$this->assertSame(200, $user->status);
	}
}
