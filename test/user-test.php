<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/user.php");


/**
 * Full PHPUnit test for the User class
 *
 * This is a complete test for the User Class. It is complete because *ALL* mySQL/PDO
 * enabled methods are tested for both invalid and valid inputs.
 *
 * @see User
 * @author Charles Sandidge <sandidgec@gmail.com>
 **/
class UserTest extends InventoryTextTest {

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
	 * @var string $root
	 */
	protected $VALID_root = "T";
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
	 * valid phoneNumber of userId
	 * @var int $phoneNumber
	 **/
	protected $VALID_phoneNumber = "5055551212";
	/**
	 * valid password hash for userId;
	 * @var string $passwordHash
	 **/
	protected $VALID_hash;
	/**
	 * valid password salt for userId;
	 * @var string $passwordSalt
	 */
	protected $VALID_salt;


	public function setUp() {
		parent::setUp();

		$this->VALID_salt = bin2hex(openssl_random_pseudo_bytes(32));
		$this->VALID_hash = hash_pbkdf2("sha512","password1234", $this->VALID_salt,262144, 128);
	}

	/**
	 * test inserting a valid User and verify that the actual mySQL data matches
	 **/
	public function testInsertValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$user = new User(null, $this->VALID_firstName, $this->VALID_lastName, $this->VALID_root, $this->VALID_addressLineOne,
				$this->VALID_addressLineTwo, $this->VALID_city, $this->VALID_state, $this->VALID_zipCode, $this->VALID_email,
				$this->VALID_phoneNumber, $this->VALID_hash, $this->VALID_salt);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertSame($pdoUser->getLastName(), $this->VALID_lastName);
		$this->assertSame($pdoUser->getFirstName(), $this->VALID_firstName);
		$this->assertSame($pdoUser->isRoot(), $this->VALID_root);
		$this->assertSame($pdoUser->getAttention(), $this->VALID_attention);
		$this->assertSame($pdoUser->getAddressLineOne(), $this->VALID_addressLineOne);
		$this->assertSame($pdoUser->getAddressLineTwo(), $this->VALID_addressLineTwo);
		$this->assertSame($pdoUser->getCity(), $this->VALID_city);
		$this->assertSame($pdoUser->getState(), $this->VALID_state);
		$this->assertSame($pdoUser->getZipCode(), $this->VALID_zipCode);
		$this->assertSame($pdoUser->getEmail(), $this->VALID_email);
		$this->assertSame($pdoUser->getHash(), $this->VALID_hash);
		$this->assertSame($pdoUser->getSalt(), $this->VALID_salt);
	}

	/**
	 * test inserting a User that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidUser() {
		// create a profile with a non null profileId and watch it fail
		$user = new User(InventoryTextTest::INVALID_KEY, $this->VALID_firstName, $this->VALID_lastName, $this->VALID_root,
					$this->VALID_attention, $this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city,
					$this->VALID_state, $this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_hash,
					$this->VALID_salt);

		$user->insert($this->getPDO());
	}

	/**
	 * test inserting a User, editing it, and then updating it
	 **/
	public function testUpdateValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$user = new User(null, $this->VALID_firstName, $this->VALID_lastName, $this->VALID_root,
					$this->VALID_attention, $this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city,
					$this->VALID_state, $this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_hash,
					$this->VALID_salt);

		$user->insert($this->getPDO());

		// edit the user and update it in mySQL
		$user->setEmail($this->VALID_email2);
		$user->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertSame($pdoUser->getLastName(), $this->VALID_lastName);
		$this->assertSame($pdoUser->getFirstName(), $this->VALID_firstName);
		$this->assertSame($pdoUser->isRoot(), $this->VALID_root);
		$this->assertSame($pdoUser->getAttention(), $this->VALID_attention);
		$this->assertSame($pdoUser->getAddressLineOne(), $this->VALID_addressLineOne);
		$this->assertSame($pdoUser->getAddressLineTwo(), $this->VALID_addressLineTwo);
		$this->assertSame($pdoUser->getCity(), $this->VALID_city);
		$this->assertSame($pdoUser->getState(), $this->VALID_state);
		$this->assertSame($pdoUser->getZipCode(), $this->VALID_zipCode);
		$this->assertSame($pdoUser->getEmail(), $this->VALID_email2);
		$this->assertSame($pdoUser->getHash(), $this->VALID_hash);
		$this->assertSame($pdoUser->getSalt(), $this->VALID_salt);
	}

	/**
	 * test updating a User that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidUser() {
		// create a User and try to update it without actually inserting it
		$user = new User (null, $this->VALID_firstName, $this->VALID_lastName, $this->VALID_root,
			$this->VALID_attention, $this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city,
			$this->VALID_state, $this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_hash,
			$this->VALID_salt);
		$user->update($this->getPDO());
	}

	/**
	 * test creating a User and then deleting it
	 **/
	public function testDeleteValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$user = new User(null, $this->VALID_firstName, $this->VALID_lastName, $this->VALID_root,
			$this->VALID_attention, $this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city,
			$this->VALID_state, $this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_hash,
			$this->VALID_salt);
		$user->insert($this->getPDO());

		// delete the User from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("user"));
		$user->delete($this->getPDO());

		// grab the data from mySQL and enforce the User does not exist
		$pdoUser = Profile::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertNull($pdoUser);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test deleting a User that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidUser() {
		// create a User and try to delete it without actually inserting it
		$user = new User(null, $this->VALID_firstName, $this->VALID_lastName, $this->VALID_root,
			$this->VALID_attention, $this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city,
			$this->VALID_state, $this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_hash,
			$this->VALID_salt);
		$user->delete($this->getPDO());
	}

	/**
	 * test inserting a User and regrabbing it from mySQL
	 **/
	public function testGetValidUserByUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new user and insert to into mySQL
		$user = new User(null, $this->VALID_firstName, $this->VALID_lastName, $this->VALID_root,
			$this->VALID_attention, $this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city,
			$this->VALID_state, $this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_hash,
			$this->VALID_salt);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertSame($pdoUser->getLastName(), $this->VALID_lastName);
		$this->assertSame($pdoUser->getFirstName(), $this->VALID_firstName);
		$this->assertSame($pdoUser->isRoot(), $this->VALID_root);
		$this->assertSame($pdoUser->getAttention(), $this->VALID_attention);
		$this->assertSame($pdoUser->getAddressLineOne(), $this->VALID_addressLineOne);
		$this->assertSame($pdoUser->getAddressLineTwo(), $this->VALID_addressLineTwo);
		$this->assertSame($pdoUser->getCity(), $this->VALID_city);
		$this->assertSame($pdoUser->getState(), $this->VALID_state);
		$this->assertSame($pdoUser->getZipCode(), $this->VALID_zipCode);
		$this->assertSame($pdoUser->getEmail(), $this->VALID_email2);
		$this->assertSame($pdoUser->getHash(), $this->VALID_hash);
		$this->assertSame($pdoUser->getSalt(), $this->VALID_salt);
	}

	/**
	 * test grabbing a User that does not exist
	 **/
	public function testGetInvalidUserByUserId() {
		// grab a user id that exceeds the maximum allowable profile id
		$user = User::getUserByUserId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($user);
	}

	/**
	 * test grabbing a User by email
	 **/
	public function testGetValidUserByEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$user = new User(null, $this->VALID_firstName, $this->VALID_lastName, $this->VALID_root,
			$this->VALID_attention, $this->VALID_addressLineOne, $this->VALID_addressLineTwo, $this->VALID_city,
			$this->VALID_state, $this->VALID_zipCode, $this->VALID_email, $this->VALID_phoneNumber, $this->VALID_hash,
			$this->VALID_salt);
		$user->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByEmail($this->getPDO(), $this->VALID_email);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertSame($pdoUser->getLastName(), $this->VALID_lastName);
		$this->assertSame($pdoUser->getFirstName(), $this->VALID_firstName);
		$this->assertSame($pdoUser->isRoot(), $this->VALID_root);
		$this->assertSame($pdoUser->getAttention(), $this->VALID_attention);
		$this->assertSame($pdoUser->getAddressLineOne(), $this->VALID_addressLineOne);
		$this->assertSame($pdoUser->getAddressLineTwo(), $this->VALID_addressLineTwo);
		$this->assertSame($pdoUser->getCity(), $this->VALID_city);
		$this->assertSame($pdoUser->getState(), $this->VALID_state);
		$this->assertSame($pdoUser->getZipCode(), $this->VALID_zipCode);
		$this->assertSame($pdoUser->getEmail(), $this->VALID_email2);
		$this->assertSame($pdoUser->getHash(), $this->VALID_hash);
		$this->assertSame($pdoUser->getSalt(), $this->VALID_salt);
	}

	/**
	 * test grabbing a User by an email that does not exists
	 **/
	public function testGetInvalidUserByEmail() {
		// grab an email that does not exist
		$user = User::getUserByEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($user);
	}
}