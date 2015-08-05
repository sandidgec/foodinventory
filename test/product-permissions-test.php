<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/product.php");

/**
 * Full PHPUnit test for the ProductPermissions class
 *
 * This is a complete PHPUnit test of the ProductPermissions class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see ProductPermissions
 * @author Marie Vigil <marie@jtdesignsolutions>
 **/
class ProductPermissionsTest extends InventoryTextTest {
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
	 * valid productId to use
	 * @var int $VALID_productId
	 **/
	protected $VALID_productId = 1;

	/**
	 * invalid productId to use
	 * @var int $INVALID_productId
	 **/
	protected $INVALID_productId = 4294967296;




	/**
	 * test inserting a valid ProductPermissions and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProductPermissions() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new ProductPermissions and insert to into mySQL
		$product = new ProductPermissions(null, $this->VALID_userId, $this->VALID_productId);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByProductPermissionsId($this->getPDO(), $product->getProductPermissionsId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProductPermissions->getAtHandle(), $this->VALID_userId);
		$this->assertSame($pdoProductPermissions->getProduct(), $this->VALID_productId);
	}

	/**
	 * test inserting a ProductPermissions that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductPermissions() {
		// create a product with a non null productId and watch it fail
		$product = new ProductPermissions(DataDesignTest::INVALID_KEY, $this->VALID_userId, $this->VALID_productId);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting a ProductPermissions, editing it, and then updating it
	 **/
	public function testUpdateValidProductPermissions() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new ProductPermissions and insert to into mySQL
		$product = new ProductPermissions(null, $this->VALID_userId, $this->VALID_productId);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByProductPermissionsId($this->getPDO(), $ProductPermissions->getProductPermissionsId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProductPermissions->getAtHandle(), $this->VALID_userId);
		$this->assertSame($pdoProductPermissions->getProduct(), $this->VALID_productId);
	}

	/**
	 * test grabbing a ProductPermission that does not exist
	 **/
	public function testGetInvalidProductPermissionByUserId() {
		// grab a user id that exceeds the maximum allowable user id
		$productPermission = ProductPermission::getProductPermissionByUserId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($productPermission);
	}

	public function testGetInvalidProductPermissionByProductId() {
		// grab a user id that exceeds the maximum allowable user id
		$productPermission = ProductPermission::getProductPermissionByProductId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($productPermission);
	}


	/**
	 * test creating a ProductPermissions and then deleting it
	 **/
	public function testDeleteValidProductPermissions() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new ProductPermissions and insert to into mySQL
		$product = new ProductPermissions(null, $this->VALID_ATHANDLE, $this->VALID_PRODUCT, $this->VALID_USER, $this->VALID_ACCESSLEVEL);
		$product->insert($this->getPDO());

		// delete the ProductPermissions from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$product->delete($this->getPDO());

		// grab the data from mySQL and enforce the ProductPermissions does not exist
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByProductPermissionsId($this->getPDO(), $product->getProductPermissionsId());
		$this->assertNull($pdoProductPermissions);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("product"));
	}

	/**
	 * test deleting a ProductPermissions that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProductPermissions() {
		// create a ProductPermissions and try to delete it without actually inserting it
		$product = new ProductPermissions(null, $this->VALID_ATHANDLE, $this->VALID_PRODUCT, $this->VALID_USER, $this->VALID_ACCESSLEVEL);
		$productPermissions->delete($this->getPDO());
	}

	/**
	 * test inserting a ProductPermissions and regrabbing it from mySQL
	 **/
	public function testGetValidProductPermissionsByProductPermissionsId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new ProductPermissions and insert to into mySQL
		$product = new ProductPermissions(null, $this->VALID_ATHANDLE, $this->VALID_PRODUCT, $this->VALID_USER, $this->VALID_ACCESSLEVEL);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByProductPermissionsId($this->getPDO(), $product->getProductPermissionsId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProductPermissions->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProductPermissions->getProduct(), $this->VALID_PRODUCT);
		$this->assertSame($pdoProductPermissions->getUser(), $this->VALID_USER);
		$this->assertSame($pdoProductPermissions->getAccessLevel(), $this->VALID_ACCESSLEVEL);
	}

	/**
	 * test grabbing a ProductPermissions that does not exist
	 **/
	public function testGetInvalidProductPermissionsByProductPermissionsId() {
		// grab a product id that exceeds the maximum allowable product id
		$product = ProductPermissions::getProductPermissionsByProductPermissionsId($this->getPDO(), DataDesignTest::INVALID_KEY);
		$this->assertNull($product);
	}

	public function testGetValidProductPermissionsByAtHandle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new ProductPermissions and insert to into mySQL
		$product = new ProductPermissions(null, $this->VALID_ATHANDLE, $this->VALID_PRODUCT, $this->VALID_USER, $this->VALID_ACCESSLEVEL);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByAtHandle($this->getPDO(), $this->VALID_ATHANDLE);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProductPermissions->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProductPermissions->getProduct(), $this->VALID_PRODUCT);
		$this->assertSame($pdoProductPermissions->getUser(), $this->VALID_USER);
		$this->assertSame($pdoProductPermissions->getAccessLevel(), $this->VALID_ACCESSLEVEL);
	}

	/**
	 * test grabbing a ProductPermissions by at handle that does not exist
	 **/
	public function testGetInvalidProductPermissionsByAtHandle() {
		// grab an at handle that does not exist
		$product = ProductPermissions::getProductPermissionsByAtHandle($this->getPDO(), "@doesnotexist");
		$this->assertNull($product);
	}

	/**
	 * test grabbing a ProductPermissions by product
	 **/
	public function testGetValidProductPermissionsByProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		/**
		 * test grabbing a ProductPermissions by user
		 **/
		public function testGetValidProductPermissionsByUSER() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("product");

			/**
			 * test grabbing a ProductPermissions by accesslevel
			 **/
			public
			function testGetValidProductPermissionsByAccessLevel() {
				// count the number of rows and save it for later
				$numRows = $this->getConnection()->getRowCount("product");
				// create a new ProductPermissions and insert to into mySQL
				$product = new ProductPermissions(null, $this->VALID_ATHANDLE, $this->VALID_PRODUCT, $this->VALID_USER, $this->VALID_ACCESSLEVEL);
				$product->insert($this->getPDO());

				// grab the data from mySQL and enforce the fields match our expectations
				$pdoProductPermissions = ProductPermissions::getProductPermissionsByProduct($this->getPDO(), $this->VALID_USER, $this->VALID_ACCESSLEVEL);
				$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
				$this->assertSame($pdoProductPermissions->getAtHandle(), $this->VALID_ATHANDLE);
				$this->assertSame($pdoProductPermissions->getProduct(), $this->VALID_PRODUCT);
				$this->assertSame($pdoProductPermissions->getUser(), $this->VALID_USER);
				$this->assertSame($pdoProductPermissions->getAccessLevel(), $this->VALID_ACCESSLEVEL);
			}

			/**
			 * test grabbing a ProductPermissions by a product that does not exists
			 **/
			public
			function testGetInvalidProductPermissionsByProduct() {
				// grab an email that does not exist
				$product = ProductPermissions::getProductPermissionsByProduct($this->getPDO(), "does@not.exist");
				$this->assertNull($product);
			}

			/**
			 * test grabbing a ProductPermissions by a user that does not exists
			 **/
			public
			function testGetInvalidProductPermissionsByUser() {
				// grab an email that does not exist
				$product = ProductPermissions::getProductPermissionsByUser($this->getPDO(), "does@not.exist");
				$this->assertNull($product);
			}

			/**
			 * test grabbing a ProductPermissions by a accesslevel that does not exists
			 **/
			public
			function testGetInvalidProductPermissionsByAccessLevel() {
				// grab an email that does not exist
				$product = ProductPermissions::getProductPermissionsByAccessLevel($this->getPDO(), "does@not.exist");
				$this->assertNull($product);
			}
		}

?>