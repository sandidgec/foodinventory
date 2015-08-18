<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the AlertLevel API
 *
 * This is a complete PHPUnit test of the AlertLevel API.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see alert-level/index
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class AlertLevelAPITest extends InventoryTextTest {
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
	 * Test Deleting a Valid AlertLevel
	 **/
	public function testDeleteValidAlertLevel() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->delete('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/' . $newAlertLevel->getAlertId(),
			['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()]]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Getting Valid AlertLevel By AlertId
	 **/
	public function testGetValidAlertLevelByAlertId() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertId=' . $newAlertLevel->getAlertId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Getting Invalid AlertLevel By AlertId
	 **/
	public function testGetInvalidAlertLevelByAlertId() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertId=' . $this->INVALID_alertId);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Getting Valid AlertLevel By AlertCode
	 **/
	public function testGetValidAlertLevelByAlertCode() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertCode=' . $newAlertLevel->getAlertCode());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Getting Invalid AlertLevel By AlertCode
	 **/
	public function testGetInvalidAlertLevelByAlertCode() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertCode=' . $this->INVALID_alertCode);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Posting Valid AlertLevel
	 **/
	public function testPostValidUser() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/?alertId=12');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->post('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/',
			['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newAlertLevel]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Putting Valid AlertLevel
	 **/
	public function testPutValidUser() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/user/' . $newAlertLevel->getAlertId(),
			['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()]]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}
}