<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/product.php");

/**
 * Full PHPUnit test for the Product class
 *
 * This is a complete PHPUnit test of the Product class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Product
 * @author Marie Vigil <marie@jtdesignsolutions>
 **/
class ProductTest extends InventoryTextTest {
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
	 * valid vendor to use
	 * @var string $VALID_VENDOR
	 **/
	protected $VALID_VENDOR = "test@phpunit.de";
	/**
	 * valid sku to use
	 * @var string $VALID_SKU
	 **/
	protected $VALID_SKU = "+12125551212";
	/**
	 * valid leadTime to use
	 * @var string $VALID_LEADTIME
	 **/
	protected $VALID_LEADTIME = "+12125551212";
	/**
	 * valid description to use
	 * @var string $VALID_DESCRIPTION
	 **/
	protected $VALID_DESCRIPTION = "test@phpunit.de";
	/**
	 * test inserting a valid Product and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProduct->getVendor(), $this->VALID_VENDOR);
		$this->assertSame($pdoProduct->getSku(), $this->VALID_SKU);
		$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_LEADTIME);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
	}

	/**
	 * test inserting a Product that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProduct() {
		// create a product with a non null productId and watch it fail
		$product = new Product(DataDesignTest::INVALID_KEY, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting a Product, editing it, and then updating it
	 **/
	public function testUpdateValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
		$product->insert($this->getPDO());

		// edit the Product and update it in mySQL
		$product->setAtHandle($this->VALID_ATHANDLE2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $Product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getAtHandle(), $this->VALID_ATHANDLE2);
		$this->assertSame($pdoProduct->getVendor(), $this->VALID_VENDOR);
		$this->assertSame($pdoProduct->getSku(), $this->VALID_SKU);
		$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_LEADTIME);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
	}

	/**
	 * test updating a Product that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProduct() {
		// create a Product and try to update it without actually inserting it
		$product = new Product(null, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
		$product->update($this->getPDO());
	}

	/**
	 * test creating a Product and then deleting it
	 **/
	public function testDeleteValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
		$product->insert($this->getPDO());

		// delete the Product from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$product->delete($this->getPDO());

		// grab the data from mySQL and enforce the Product does not exist
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertNull($pdoProduct);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("product"));
	}

	/**
	 * test deleting a Product that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProduct() {
		// create a Product and try to delete it without actually inserting it
		$product = new Product(null, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
		$Product->delete($this->getPDO());
	}

	/**
	 * test inserting a Product and regrabbing it from mySQL
	 **/
	public function testGetValidProductByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProduct->getVendor(), $this->VALID_VENDOR);
		$this->assertSame($pdoProduct->getSku(), $this->VALID_SKU);
		$this->assertSame($pdoProduct->getLeadTIme(), $this->VALID_LEADTIME);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
	}

	/**
	 * test grabbing a Product that does not exist
	 **/
	public function testGetInvalidProductByProductId() {
		// grab a product id that exceeds the maximum allowable product id
		$product = Product::getProductByProductId($this->getPDO(), DataDesignTest::INVALID_KEY);
		$this->assertNull($product);
	}

	public function testGetValidProductByAtHandle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProduct = Product::getProductByAtHandle($this->getPDO(), $this->VALID_ATHANDLE);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProduct->getAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProduct->getVendor(), $this->VALID_VENDOR);
		$this->assertSame($pdoProduct->getSku(), $this->VALID_SKU);
		$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_LEADTIME);
		$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
	}

	/**
	 * test grabbing a Product by at handle that does not exist
	 **/
	public function testGetInvalidProductByAtHandle() {
		// grab an at handle that does not exist
		$product = Product::getProductByAtHandle($this->getPDO(), "@doesnotexist");
		$this->assertNull($product);
	}

	/**
	 * test grabbing a Product by vendor
	 **/
	public function testGetValidProductByVendor() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		/**
		 * test grabbing a Product by sku
		 **/
		public function testGetValidProductBySKU() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("product");

			/**
			 * test grabbing a Product by leadtime
			 **/
			public function testGetValidProductByLeadTime() {
				// count the number of rows and save it for later
				$numRows = $this->getConnection()->getRowCount("product");

				/**
				 * test grabbing a Product by description
				 **/
				public function testGetValidProductByDescription() {
					// count the number of rows and save it for later
					$numRows = $this->getConnection()->getRowCount("product");

					// create a new Product and insert to into mySQL
					$product = new Product(null, $this->VALID_ATHANDLE, $this->VALID_VENDOR, $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
					$product->insert($this->getPDO());

					// grab the data from mySQL and enforce the fields match our expectations
					$pdoProduct = Product::getProductByVendor($this->getPDO(), $this->VALID_SKU, $this->VALID_LEADTIME, $this->VALID_DESCRIPTION);
					$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
					$this->assertSame($pdoProduct->getAtHandle(), $this->VALID_ATHANDLE);
					$this->assertSame($pdoProduct->getVendor(), $this->VALID_VENDOR);
					$this->assertSame($pdoProduct->getSku(), $this->VALID_SKU);
					$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_LEADTIME);
					$this->assertSame($pdoProduct->getDescription(), $this->VALID_DESCRIPTION);
				}

				/**
				 * test grabbing a Product by a vendor that does not exists
				 **/
				public function testGetInvalidProductByVendor() {
					// grab an email that does not exist
					$product = Product::getProductByVendor($this->getPDO(), "does@not.exist");
					$this->assertNull($product);
				}
				/**
				 * test grabbing a Product by a sku that does not exists
				 **/
				public function testGetInvalidProductBySku() {
					// grab an email that does not exist
					$product = Product::getProductBySku($this->getPDO(), "does@not.exist");
					$this->assertNull($product);
				}
				/**
				 * test grabbing a Product by a leadtime that does not exists
				 **/
				public function testGetInvalidProductByLeadTime() {
					// grab an email that does not exist
					$product = Product::getProductByLeadTime($this->getPDO(), "does@not.exist");
					$this->assertNull($product);
				}
				/**
				 * test grabbing a Product by a description that does not exists
				 **/
				public function testGetInvalidProductByDescription() {
					// grab an email that does not exist
					$product = Product::getProductByDescription($this->getPDO(), "does@not.exist");
					$this->assertNull($product);
				}
			}