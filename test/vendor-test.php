<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/vendor.php");

/**
 * Full PHPUnit test for the Vendor class
 *
 * This is a complete PHPUnit test of the Vendor class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Vendor
 * @author James Huber <jhuber8@cnm.edu>
 **/
class VendorTest extends InventoryTextTest {
	/**
	 * valid at vendor id to use
	 * @var int $VALID_vendorId
	 **/
	protected $VALID_vendorId = "69";
	/**
	 * invalid vendor id to use
	 * @var int $INVALID_vendorId
	 **/
	protected $INVALID_vendorId = "4294967296";
	/**
	 * valid contact name to use
	 * @var string $VALID_contactName
	 **/
	protected $VALID_contactName = "Topher Sucks";
	/**
	 * valid contact name 2 to use
	 * @var string $VALID_contactName2
	 **/
	protected $VALID_contactName2 = "Charles Sandidge";
	/**
	 * invalid contact name to use
	 * @var string $INVALID_contactName
	 **/
	protected $INVALID_contactName = "-6";
	/**
	 * valid vendor email to use
	 * @var string $VALID_vendorEmail
	 **/
	protected $VALID_vendorEmail = "topersucks@myunit.test";
	/**
	 * invalid vendor email to use
	 * @var int $VALID_emailStatus
	 **/
	protected $INVALID_vendorEmail = "@myunit.test";
	/**
	 * valid vendorName to use
	 * @var string $VALID_vendorName
	 **/
	protected $VALID_vendorName = "php  unit test Co";
	/**
	 * invalid vendor email to use
	 * @var string $INVALID_vendorEmail
	 **/
	protected $INVALID_vendorName = "Bobbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb";
	/**
	 * valid vendor phone number to use
	 * @var string $VALID-vendorPhoneNumber
	 **/
	protected $VALID_vendorPhoneNumber = "5555555555";
	/**
	 * second valid notification to use
	 * @var string $VALID_notificationHandle2
	 **/
	protected $INVALID_vendorPhoneNumber = "555555555555555555555";

	/**
	 * test inserting a valid Vendor and verify that the actual mySQL data matches
	 **/
	public function testInsertValidVendor() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vendor");

		// create a new Vendor and insert to into mySQL
		$vendor = new Vendor (null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVendor = Vendor::getVendorByVendorId($this->getPDO(), $vendor->getVendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("vendor"));
		$this->assertSame($pdoVendor->getContactName(), $this->VALID_contactName);
		$this->assertSame($pdoVendor->getVendorEmail(), $this->VALID_vendorEmail);
		$this->assertSame($pdoVendor->getVendorName(), $this->VALID_vendorName);
		$this->assertSame($pdoVendor->getVendorPhoneNumber(), $this->VALID_vendorPhoneNumber);
	}

	/**
	 * test inserting a Vendor that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidVendor() {
		// create a vendor with a non null notificationId and watch it fail
		$vendor = new Vendor(InventoryTextTest::INVALID_KEY,$this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());
	}

	/**
	 * test inserting a Vendor, editing it, and then updating it
	 **/
	public function testUpdateValidVendor() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vendor");

		// create a new vendor and insert to into mySQL
		$vendor = new vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		// edit the Notification and update it in mySQL
		$vendor->setContactName($this->VALID_contactName2);
		$vendor->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVendor = Vendor::getVendorByVendorId($this->getPDO(), $vendor->getVendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("vendor"));
		$this->assertSame($pdoVendor->getContactName(), $this->VALID_contactName2);
		$this->assertSame($pdoVendor->getVendorEmail(), $this->VALID_vendorEmail);
		$this->assertSame($pdoVendor->getVendorName(), $this->VALID_vendorName);
		$this->assertSame($pdoVendor->getVendorPhoneNumber(), $this->VALID_vendorPhoneNumber);
	}

	/**
	 * test updating a Vendor that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidVendor(){
		//create a Vendor and try to update it wiehtout actually inserting it
		$vendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor -> update($this->getPDO());
	}
	/**
	 * test creating a Vendor and then deleting it
	 **/
	public function testDeleteValidVendor() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vendor");

		// create a new Profile and insert to into mySQL
		$vendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		// delete the Vendor from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("vendor"));
		$vendor->delete($this->getPDO());

		// grab the data from mySQL and enforce the Vendor does not exist
		$pdoVendor = Vendor::getVendorByVendorId($this->getPDO(), $vendor->getvendorId());
		$this->assertNull($pdoVendor);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("vendor"));
	}

	/**
	 * test deleting a Vendor that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidVendor() {
		// create a Vendor and try to delete it without actually inserting it
		$vendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->delete($this->getPDO());
	}
	/**
	 * test inserting a Vendor and regrabbing it from mySQL
	 **/
	public function testGetValidVendorByVendorId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vendor");

		// create a new Vendor and insert to into mySQL
		$vendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVendor = Vendor::getVendorByVendorId($this->getPDO(), $vendor->getVendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("vendor"));
		$this->assertSame($pdoVendor->getContactName(), $this->VALID_contactName);
		$this->assertSame($pdoVendor->getVendorEmail(), $this->VALID_vendorEmail);
		$this->assertSame($pdoVendor->getVendorName(), $this->VALID_vendorName);
		$this->assertSame($pdoVendor->getVendorPhoneNumber(), $this->VALID_vendorPhoneNumber);
	}

	/**
	 * test grabbing a Vendor that does not exist
	 **/
	public function testGetInvalidVendorByVendorId() {
		// grab a vendor id that exceeds the maximum allowable vendor id
		$vendor = Vendor::getVendorByVendorId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($vendor);
	}

	/**
	 * test grabbing a Vendor by vendor email
	 **/
	public function testGetValidVendorByVendorEmail() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vendor");

		// create a new Vendor and insert to into mySQL
		$vendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVendor = Vendor::getVendorByVendorEmail($this->getPDO(), $vendor->getVendorEmail());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("vendor"));
		$this->assertSame($pdoVendor->getContactName(), $this->VALID_contactName);
		$this->assertSame($pdoVendor->getVendorEmail(), $this->VALID_vendorEmail);
		$this->assertSame($pdoVendor->getVendorName(), $this->VALID_vendorName);
		$this->assertSame($pdoVendor->getVendorPhoneNumber(), $this->VALID_vendorPhoneNumber);
	}

	/**
	 * test grabbing a vendor by an vendor email that does not exists
	 **/
	public function testGetInvalidVendorByVendorEmail() {
		// grab an vendor email that does not exist
		$vendor = Vendor::getVendorByVendorEmail($this->getPDO(), "4294967296");
		$this->assertNull($vendor);
	}
	/**
	 * test grabbing a Vendor by vendor name
	 **/
	public function testGetValidVendorByVendorName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vendor");

		// create a new Vendor and insert to into mySQL
		$vendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVendor = Vendor::getVendorByVendorName($this->getPDO(), $vendor->getVendorName());
		foreach($pdoVendor as $ven)
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("vendor"));
		$this->assertSame($ven->getContactName(), $this->VALID_contactName);
		$this->assertSame($ven->getVendorEmail(), $this->VALID_vendorEmail);
		$this->assertSame($ven->getVendorName(), $this->VALID_vendorName);
		$this->assertSame($ven->getVendorPhoneNumber(), $this->VALID_vendorPhoneNumber);
	}

	/**
	 * test grabbing a vendor by a vendor name that does not exists
	 **/
	public function testGetInvalidVendorByVendorName() {
		// grab an vendor name that does not exist
		$vendor = Vendor::getVendorByVendorName($this->getPDO(), "4294967296");
		foreach($vendor as $ven){
			$this->assertNull($ven);
		}
	}
}