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
	 * test grabbing a AlertLevel by valid alertId
	 **/
	public function testGetValidAlertLevelByAlertId() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel(null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertId=' . $newAlertLevel->getAlertId());
		var_dump($this->guzzle);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * test grabbing a AlertLevel by invalid alertId
	 **/
	public function testGetInvalidAlertLevelByAlertId() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}
}