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
	 * valid at handle to use
	 * @var string $VALID_ATHANDLE
	 **/
	protected $VALID_ATHANDLE = "@phpunit";
	/**
	 * second valid at handle to use
	 * @var string $VALID_ATHANDLE2
	 **/
	protected $VALID_ATHANDLE2 = "@passingtests";
	/**
	 * valid product to use
	 * @var string $VALID_PRODUCT
	 **/
	protected $VALID_PRODUCT = "test@phpunit.de";
	/**
	 * valid user to use
	 * @var string $VALID_USER
	 **/
	protected $VALID_USER = "+12125551212";
	/**
	 * valid leadTime to use
	 * @var string $VALID_ACCESSLEVEL
	 **/
	protected $VALID_ACCESSLEVEL = "+12125551212";
	/**
	 * test inserting a valid ProductPermissions and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProductPermissions() {
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
	 * test inserting a ProductPermissions that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProductPermissions() {
		// create a product with a non null productId and watch it fail
		$product = new ProductPermissions(DataDesignTest::INVALID_KEY, $this->VALID_ATHANDLE, $this->VALID_PRODUCT, $this->VALID_USER, $this->VALID_ACCESSLEVEL);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting a ProductPermissions, editing it, and then updating it
	 **/
	public function testUpdateValidProductPermissions() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new ProductPermissions and insert to into mySQL
		$product = new ProductPermissions(null, $this->VALID_ATHANDLE, $this->VALID_PRODUCT, $this->VALID_USER, $this->VALID_ACCESSLEVEL);
		$product->insert($this->getPDO());

		// edit the ProductPermissions and update it in mySQL
		$product->setAtHandle($this->VALID_ATHANDLE2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductPermissions = ProductPermissions::getProductPermissionsByProductPermissionsId($this->getPDO(), $ProductPermissions->getProductPermissionsId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProductPermissions->getAtHandle(), $this->VALID_ATHANDLE2);
		$this->assertSame($pdoProductPermissions->getProduct(), $this->VALID_PRODUCT);
		$this->assertSame($pdoProductPermissions->getUser(), $this->VALID_USER);
		$this->assertSame($pdoProductPermissions->getAccessLevel(), $this->VALID_ACCESSLEVEL);
	}

	/**
	 * test updating a ProductPermissions that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProductPermissions() {
		// create a ProductPermissions and try to update it without actually inserting it
		$product = new ProductPermissions(null, $this->VALID_ATHANDLE, $this->VALID_PRODUCT, $this->VALID_USER, $this->VALID_ACCESSLEVEL);
		$product->update($this->getPDO());
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
		$ProductPermissions->delete($this->getPDO());
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
				$this->assertNull($product)
			}
		}