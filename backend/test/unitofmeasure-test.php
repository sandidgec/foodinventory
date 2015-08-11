<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/unit-of-measure.php");


/**
 * Full PHPUnit test for the Unit of Measure class
 *
 * This is a complete test for the Unit of Measure Class. It is complete because *ALL* mySQL/PDO
 * enabled methods are tested for both invalid and valid inputs.
 *
 * @see unit-of-measure
 * @author Charles Sandidge <sandidgec@gmail.com>
 **/
class UnitOfMeasureTest extends InventoryTextTest {

	/**
	 * Valid unitId
	 * @var int $unitId
	 */
	protected $VALID_unitId = 12;
	/**
	 * valid unitCode
	 * @var string $unitCode
	 **/
	protected $VALID_unitCode = "ea";
	/**
	 * 2nd valid unitCode
	 * @var string
	 */
	protected $VALID_unitCode2 = "lb";
	/**
	 * Invalid Unit Code for testing
	 * @var string
	 */
	protected $INVALID_unitCode = "xy";
	/**
	 * valid description of quantity
	 * @var int $quantity
	 **/
	protected $VALID_quantity = 4.00;



	/**
	 * test inserting a valid Unit of Measure and verify that the actual mySQL data matches
	 **/
	public function testInsertValidUnitOfMeasure() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("unitOfMeasure");

		// create a new Unit Of Measure and insert to into mySQL
		$unitOfMeasure = new UnitOfMeasure(null, $this->VALID_unitCode, $this->VALID_quantity);
		$unitOfMeasure->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUnitOfMeasure = UnitOfMeasure::getUnitOfMeasureByUnitId($this->getPDO(), $unitOfMeasure->getUnitId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("unitOfMeasure"));
		$this->assertSame($pdoUnitOfMeasure->getUnitCode(), $this->VALID_unitCode);
		$this->assertSame($pdoUnitOfMeasure->getQuantity(), $this->VALID_quantity);
	}

	/**
	 * test inserting a Unit of Measure that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidUnitOfMeasure() {
		// create a Unit of Measure with a non null unitId and watch it fail
		$unitOfMeasure = new UnitOfMeasure(InventoryTextTest::INVALID_KEY, $this->VALID_unitCode, $this->VALID_quantity);

		$unitOfMeasure->insert($this->getPDO());
	}

	/**
	 * test inserting a Unit Of Measure, editing it, and then updating it
	 **/
	public function testUpdateValidUnitOfMeasure() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("unitOfMeasure");

		// create a new Unit of Measure and insert to into mySQL
		$unitOfMeasure = new UnitOfMeasure(null, $this->VALID_unitCode, $this->VALID_quantity);

		$unitOfMeasure->insert($this->getPDO());

		// edit the Unit of Measure and update it in mySQL
		$unitOfMeasure->setUnitCode($this->VALID_unitCode2);
		$unitOfMeasure->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoLocation = UnitOfMeasure::getUnitOfMeasureByUnitId($this->getPDO(), $unitOfMeasure->getUnitId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("unitOfMeasure"));
		$this->assertSame($pdoLocation->getUnitCode(), $this->VALID_unitCode2);
		$this->assertSame($pdoLocation->getQuantity(), $this->VALID_quantity);

	}

	/**
	 * test updating a Unit of Measure that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidUnitOfMeasure() {
		// create a Unit of Measure and try to update it without actually inserting it
		$unitOfMeasure = new UnitOfMeasure(null, $this->VALID_unitCode, $this->VALID_quantity);
		$unitOfMeasure->update($this->getPDO());
	}

	/**
	 * test creating a Unit of Measure and then deleting it
	 **/
	public function testDeleteValidUnitOfMeasure() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("unitOfMeasure");

		// create a new UnitOfMeasure and insert to into mySQL
		$unitOfMeasure = new UnitOfMeasure(null, $this->VALID_unitCode, $this->VALID_quantity);
		$unitOfMeasure->insert($this->getPDO());

		// delete the Unit Of Measure from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("unitOfMeasure"));
		$unitOfMeasure->delete($this->getPDO());

		// grab the data from mySQL and enforce the Location does not exist
		$pdoUnitOfMeasure = UnitOfMeasure::getUnitOfMeasureByUnitId($this->getPDO(),$unitOfMeasure->getUnitId());
		$this->assertNull($pdoUnitOfMeasure);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("unitOfMeasure"));
	}


	/**
	 * test deleting a Unit Of Measure that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidUnitOfMeasure() {
		// create a Unit Of Measure and try to delete it without actually inserting it
		$unitOfMeasure= new UnitOfMeasure(null, $this->VALID_unitCode, $this->VALID_quantity);
		$unitOfMeasure->delete($this->getPDO());
	}

	/**
	 * test inserting a Unit Of Measure and regrabbing it from mySQL
	 **/
	public function testGetValidLocationrByLocationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("unitOfMeasure");

		// create a new unit of measure and insert to into mySQL
		$unitOfMeasure = new UnitOfMeasure(null, $this->VALID_unitCode, $this->VALID_quantity);
		$unitOfMeasure->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUnitOfMeasure = UnitOfMeasure::getUnitOfMeasureByUnitId($this->getPDO(), $unitOfMeasure->getUnitId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("unitOfMeasure"));
		$this->assertSame($pdoUnitOfMeasure->getUnitCode(), $this->VALID_unitCode);
		$this->assertSame($pdoUnitOfMeasure->getQuantity(), $this->VALID_quantity);

	}

	/**
	 * test grabbing a Unit Of Measure that does not exist
	 **/
	public function testGetInvalidUnitOfMeasureByUnitId() {
		// grab a unit of measure id that exceeds the maximum allowable unit id
		$unitOfMeasure = UnitOfMeasure::getUnitOfMeasureByUnitId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($unitOfMeasure);
	}

	/**
	 * test grabbing a Unit of Measure by unitCode
	 **/
	public function testGetValidUserByStorageCode() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("unitOfMeasure");

		// create a new Location and insert to into mySQL
		$unitOfMeasure = new UnitOfMeasure(null, $this->VALID_unitCode, $this->VALID_quantity);
		$unitOfMeasure->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUnitOfMeasure =UnitOfMeasure::getUnitOfMeasureByUnitCode($this->getPDO(), $this->VALID_unitCode);
		foreach ($pdoUnitOfMeasure as $uOM) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("unitOfMeasure"));
			$this->assertSame($uOM->getUnitCode(), $this->VALID_unitCode);
			$this->assertSame($uOM->getQuantity(), $this->VALID_quantity);
		}
	}

	/**
	 * test grabbing a Unit of Measure by an unitCode that does not exists
	 **/
	public function testGetInvalidUnitOfMeasureByUnitCode() {
		// grab a unit code that does not exist
		$unitOfMeasure = UnitOfMeasure::getUnitOfMeasureByUnitCode($this->getPDO(),$this->INVALID_unitCode);
		$this->assertNull($unitOfMeasure);
	}
}

