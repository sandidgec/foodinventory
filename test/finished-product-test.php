<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/finished-product.php");
require_once(dirname(__DIR__) . "/php/classes/product.php");
require_once(dirname(__DIR__) . "/php/classes/vendor.php");

/**
 * Full PHPUnit test for the FinishedProduct class
 *
 * This is a complete PHPUnit test of the FinishedProduct class.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see FinishedProduct
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class FinishedProductTest extends InventoryTextTest {
	/**
	 * valid rawQuantity to use
	 * @var float $VALID_quantity
	 **/
	protected $VALID_rawQuantity = 400.25;

	/**
	 * valid second rawQuantity to use
	 * @var float $VALID_rawQuantity2
	 **/
	protected $VALID_rawQuantity2 = 225.50;

	/**
	 * invalid rawQuantity to use
	 * @var float $INVALID_rawQuantity
	 **/
	protected $INVALID_rawQuantity = 42949.67296;

	/**
	 * creating a null Product
	 * object for global scope
	 * @var Product $finishedProduct
	 **/
	protected $finishedProduct = null;

	/**
	 * creating a null Product
	 * object for global scope
	 * @var Product $rawMaterial
	 **/
	protected $rawMaterial = null;


	public function setUp() {
		parent::setUp();

		$vendorId = null;
		$name = "TruFork";
		$contactName = "Trevor Rigler";
		$email = "trier@cnm.edu";
		$phoneNumber = "5053594687";

		$vendor = new Vendor($vendorId, $name, $contactName, $email, $phoneNumber);
		$vendor->insert($this->getPDO());

		$productId = null;
		$vendorId = $vendor->getVendorId();
		$description = "A glorius bracelet for any occasion to use";
		$leadTime = 15;
		$sku = "457847";
		$title = "Bracelet-Green-Blue";

		$this->finishedProduct = new Product($productId, $vendorId, $description, $leadTime, $sku, $title);
		$this->finishedProduct->insert($this->getPDO());

		$productId = null;
		$vendorId = $vendor->getVendorId();
		$description = "A glorius bead to use";
		$leadTime = 10;
		$sku = "TGT354";
		$title = "Bead-Green-Blue-Circular";

		$this->rawMaterial = new Product($productId, $vendorId, $description, $leadTime, $sku, $title);
		$this->rawMaterial->insert($this->getPDO());
	}


	/**
	 * test inserting a valid FinishedProduct and verify that the actual mySQL data matches
	 **/
	public function testInsertValidFinishedProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("finishedProduct");

		// create a new FinishedProduct and insert to into mySQL
		$finishedProduct = new FinishedProduct($this->finishedProduct->getProductId(), $this->rawMaterial->getProductId(), $this->VALID_rawQuantity);
		$finishedProduct->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFinishedProduct = FinishedProduct::getFinishedProductByFinishedProductIdAndRawMaterialId($this->getPDO(), $this->finishedProduct->getProductId(), $this->rawMaterial->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("finishedProduct"));
		$this->assertSame($pdoFinishedProduct->getRawQuantity(), $this->VALID_rawQuantity);
	}

	/**
	 * test grabbing a FinishedProduct that does not exist
	 **/
	public function testGetInvalidFinishedProductByFinishedProductIdAndRawMaterialId() {
		// grab a finishedProductId that exceeds the maximum allowable finishedProductId
		$finishedProduct = new FinishedProduct(InventoryTextTest::INVALID_KEY, $this->rawMaterial->getProductId(), $this->VALID_rawQuantity);
		$this->assertNull($finishedProduct);
	}

	/**
	 * test inserting a FinishedProduct, editing it, and then updating it
	 **/
	public function testUpdateValidFinishedProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("finishedProduct");

		// create a new FinishedProduct and insert to into mySQL
		$finishedProduct = new FinishedProduct($this->finishedProduct->getProductId(), $this->rawMaterial->getProductId(), $this->VALID_rawQuantity);
		$finishedProduct->insert($this->getPDO());

		// edit the FinishedProduct and update it in mySQL
		$finishedProduct->setRawQuantity($this->VALID_rawQuantity2);
		$finishedProduct->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFinishedProduct = FinishedProduct::getFinishedProductByFinishedProductIdAndRawMaterialId($this->getPDO(), $this->finishedProduct->getProductId(), $this->rawMaterial->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("finishedProduct"));
		$this->assertSame($pdoFinishedProduct->getRawQuantity(), $this->VALID_rawQuantity2);
	}

	/**
	 * test updating a FinishedProduct that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidFinishedProduct() {
		// create a FinishedProduct and try to update it without actually inserting it
		$finishedProduct = new FinishedProduct($this->finishedProduct->getProductId(), $this->rawMaterial->getProductId(), $this->VALID_rawQuantity);
		$finishedProduct->update($this->getPDO());
	}

	/**
	 * test creating a FinishedProduct and then deleting it
	 **/
	public function testDeleteValidFinishedProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("finishedProduct");

		// create a new FinishedProduct and insert to into mySQL
		$finishedProduct = new FinishedProduct($this->finishedProduct->getProductId(), $this->rawMaterial->getProductId(), $this->VALID_rawQuantity);
		$finishedProduct->insert($this->getPDO());

		// delete the FinishedProduct from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("finishedProduct"));
		$finishedProduct->delete($this->getPDO());

		// grab the data from mySQL and enforce the ProductLocation does not exist
		$pdoFinishedProduct = FinishedProduct::getFinishedProductByFinishedProductIdAndRawMaterialId($this->getPDO(), $this->finishedProduct->getProductId(), $this->rawMaterial->getProductId());
		$this->assertNull($pdoFinishedProduct);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("finishedProduct"));
	}

	/**
	 * test deleting a FinishedProduct that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidFinishedProduct() {
		// create a FinishedProduct and try to delete it without actually inserting it
		$finishedProduct = new FinishedProduct($this->finishedProduct->getProductId(), $this->rawMaterial->getProductId(), $this->VALID_rawQuantity);
		$finishedProduct->delete($this->getPDO());
	}

	/**
	 * test grabbing a FinishedProduct by finishedProductId
	 **/
	public function testGetValidFinishedProductByFinishedProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("finishedProduct");

		// create a new FinishedProduct and insert to into mySQL
		$finishedProduct = new FinishedProduct($this->finishedProduct->getProductId(), $this->rawMaterial->getProductId(), $this->VALID_rawQuantity);
		$finishedProduct->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFinishedProduct = FinishedProduct::getFinishedProductByFinishedProductId($this->getPDO(), $this->finishedProduct->getProductId());
		foreach($pdoFinishedProduct as $pdoFP) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("finishedProduct"));
			$this->assertSame($pdoFP->getRawMaterialId, $this->rawMaterial->getProductId());
			$this->assertSame($pdoFP->getRawQuantity(), $this->VALID_rawQuantity);
		}
	}

	/**
	 * test grabbing a FinishedProduct by finishedProductId that does not exist
	 **/
	public function testGetInvalidFinishedProductByFinishedProductId() {
		// grab an finishedProductId that does not exist
		$finishedProduct = FinishedProduct::getFinishedProductByFinishedProductId($this->getPDO(), $this->finishedProduct->getProductId());
		$this->assertNull($finishedProduct);
	}

	/**
	 * test grabbing a FinishedProduct by rawMaterialId
	 **/
	public function testGetValidFinishedProductByRawMaterialId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("finishedProduct");

		// create a new FinishedProduct and insert to into mySQL
		$finishedProduct = new FinishedProduct($this->finishedProduct->getProductId(), $this->rawMaterial->getProductId(), $this->VALID_rawQuantity);
		$finishedProduct->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFinishedProduct = FinishedProduct::getFinishedProductByRawMaterialId($this->getPDO(), $this->rawMaterial->getProductId());
		foreach($pdoFinishedProduct as $pdoFP) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("finishedProduct"));
			$this->assertSame($pdoFP->getFinishedProductId, $this->finishedProduct->getProductId());
			$this->assertSame($pdoFP->getRawQuantity(), $this->VALID_rawQuantity);
		}
	}

	/**
	 * test grabbing a FinishedProduct by rawMaterialId that does not exist
	 **/
	public function testGetInvalidFinishedProductByRawMaterialId() {
		// grab an rawMaterialId that does not exist
		$finishedProduct = FinishedProduct::getFinishedProductByRawMaterialId($this->getPDO(), $this->rawMaterial->getProductId());
		$this->assertNull($finishedProduct);
	}
}