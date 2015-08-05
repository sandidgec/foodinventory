<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/product-permissions.php");

/**
 * Full PHPUnit test for the Product Permissions class
 *
 * This is a complete PHPUnit test of the Product Permissions class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Product Permissions
 * @author Marie Vigil <marie@jtdesignsolutions.com>
 **/
class ProductPermissionsTest extends InventoryTextTest {
	/**
	 * valid productId to use
	 * @var int $VALID_productId
	 **/
	protected $VALID_productId = 1;

	/**
	 * invalid productId to use
	 * @var int $INVALID_userId
	 **/
	protected $INVALID_productId = 4294967296;

	/**
	 * valid userId to use
	 * @var int $VALID_userId
	 **/
	protected $VALID_userId = 1;

	/**
	 * invalid userId to use
	 * @var int $INVALID_userId
	 **/
	protected $INVALID_userId = 4294967296;

	/**
	 * valid accessLevel to use
	 * @var int $VALID_accessLevel
	 **/
	protected $VALID_accessLevel = 1;

	/**
	 * invalid accessLevel to use
	 * @var int $INVALID_accessLevel
	 **/
	protected $INVALID_accessLevel = 4294967296;

	/**
	 * test inserting a valid Product Permissions and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProductPermissions() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product permissions");

		// create a new Product Permissions and insert to into mySQL
		$productPermissions = new productPermissions(null, $this->VALID_productId, $this->VALID_userId);
		$productPermissions->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByUserId($this->getPDO(), $productPermissions->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product permissions"));
		$this->assertSame($pdoProductPermissions->getproductId(), $this->VALID_productId);
	}

	/**
	 * test inserting a Product Permissions that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductPermissions() {
		// create a product permissions with a non null Product Permissions and watch it fail
		$productPermissions = new ProductPermissions(InventoryTextTest::INVALID_KEY, $this->INVALID_productId, $this->INVALID_userId, $this->INVALID_accessLevel);
		$productPermissions->insert($this->getPDO());
	}

	/**
	 * test inserting a Product Permissions and regrabbing it from mySQL
	 **/
	public function testGetValidProductPermissionsByProductPermissionsId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product permissions");

		// create a new Product Permissions and insert it into mySQL
		$productPermissions = new ProductPermissions(null, $this->VALID_productId, $this->VALID_userId, $this->INVALID_accessLevel);
		$productPermissions->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByProductPermissionsId($this->getPDO(), $productPermissions->getProductPermissionsId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product permissions"));
		$this->assertSame($pdoProductPermissions->getProductId(), $this->VALID_productId);
		$this->assertSame($pdoProductPermissions->getUserId(), $this->VALID_userId);
	}

	/**
	 * test grabbing a Product Permissions that does not exist
	 **/
	public function testGetInvalidProductPermissionsByProductPermissionsId() {
		// grab a Product Permissions id that exceeds the maximum allowable Product Permissions id
		$productPermissions = ProductPermissions::getProductPermissionsByProductPermissionsId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($productPermissions);
	}

	/**
	 * test grabbing a Product Permissions by productId
	 **/
	public function testGetValidProductPermissionsByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product permissions");

		// create a new Product Permissions and insert to into mySQL
		$productPermissions = new ProductPermissions(null, $this->VALID_productId, $this->VALID_userId, $this->INVALID_accessLevel);
		$productPermissions->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByProductId($this->getPDO(), $productPermissions->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product permissions"));
		$this->assertSame($pdoProductPermissions->getProductId(), $this->VALID_userId, $this->INVALID_accessLevel);
	}

	/**
	 * test grabbing a Product Permissions by productId that does not exist
	 **/
	public function testGetInvalidProductPermissionsByProductId() {
		// grab an productId that does not exist
		$productPermissions = ProductPermissions::getProductPermissionsByProductId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($productPermissions);
	}

	/**
	 * test grabbing a Product Permissions by userId
	 **/
	public function testGetValidProductPermissionsByUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("productPermissions");

		// create a new Product Permissions and insert to into mySQL
		$productPermissions = new ProductPermissions(null, $this->VALID_productId, $this->VALID_userId);
		$productPermissions->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getMovementByProductId($this->getPDO(), $productPermissions->getUserId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product permissions"));
		$this->assertSame($pdoProductPermissions->getProductId(), $this->VALID_userId);
		$this->assertSame($pdoProductPermissions->getUserId(), $this->VALID_userId);
	}
}