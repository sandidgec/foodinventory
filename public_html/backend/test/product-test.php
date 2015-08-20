<?php
/**
 * product unit test for foodinventory
 *
 * This product unit test is a single class within the overall foodinventory application
 *
 * @author Marie Vigil <marie@jtdesignsolutions>
 *
 **/

// grab the project test parameters
require_once("inventorytext.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Product class
 *
 * This is a complete PHPUnit test of the Product class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Product
 * @author Marie Vigil <marie@jtdesignsolutions.com>
 **/
class ProductTest extends InventoryTextTest {
	/**
	 * valid description to use
	 * @var string $VALID_description
	 **/
	protected $VALID_description = "kids";

	/**
	 * invalid description to use
	 * @var string $INVALID_description
	 **/
	protected $INVALID_description = null;

	/**
	 * valid leadTime to use
	 * @var int $VALID_leadTime
	 **/
	protected $VALID_leadTime = 1;

	/**
	 * valid leadTime2 to use
	 * @var int $VALID_leadTime2
	 **/
	protected $VALID_leadTime2 = 2;

	/**
	 * invalid leadTime to use
	 * @var int $INVALID_leadTime
	 **/
	protected $INVALID_leadTime = 4294967296;

	/**
	 * valid sku to use
	 * @var int $VALID_sku
	 **/
	protected $VALID_sku = "TGT345";

	/**
	 * invalid sku to use
	 * @var int $INVALID_sku
	 **/
	protected $INVALID_sku = 4294967296;

	/**
	 * valid title to use
	 * @var string $VALID_title
	 **/
	protected $VALID_title = "test";

	/**
	 * invalid title to use
	 * @var string $INVALID_title
	 **/
	protected $INVALID_title = null;

	/**
	 * creating a null Vendor
	 * object for global scope
	 * @var Vendor $vendor
	 **/
	protected $vendor = null;


	/**
	 * creating a null Location
	 * object for global scope
	 * @var Location $location
	 **/
	protected $location = null;


	/**
	 * creating a null Location
	 * object for global scope
	 * @var UnitOfMeasure $unitOfMeasure
	 **/
	protected $unitOfMeasure = null;

	/**
	 * creating a null Finished Product
	 * object for global scope
	 * @var Finished Product $finishedProduct
	 **/
	protected $finishedProduct = null;

	/**
	 * create dependent objects before running each test
	 **/

	public function setUp() {
		parent::setUp();

		$vendorId = null;
		$contactName = "Trevor Rigler";
		$vendorEmail = "trier@cnm.edu";
		$vendorName = "TruFork";
		$vendorPhoneNumber = "5053594687";

		$vendor = new Vendor($vendorId, $contactName, $vendorEmail, $vendorName, $vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		$productId = null;
		$vendorId = $vendor->getVendorId();
		$description = "A glorius bead to use";
		$leadTime = 10;
		$sku = "TGT354";
		$title = "Bead-Green-Blue-Circular";

		$this->product = new Product($productId, $vendorId, $description, $leadTime, $sku, $title);
		$this->product->insert($this->getPDO());

		$finishedProductId = null;
		$rawMaterialId =  "5053594687";
		$rawQuantity = 400.25;

		$this->finishedProduct = new FinishedProduct($finishedProductId, $rawMaterialId, $rawQuantity);
		$this->finishedProduct->insert($this->getPDO());

		$locationId = null;
		$description = "Front Stock";
		$storageCode = 12;

		$this->location = new Location($locationId, $storageCode, $description);
		$this->location->insert($this->getPDO());

		$unitId = null;
		$unitCode = "pk";
		$quantity = 10.50;

		$this->unitOfMeasure = new UnitOfMeasure($unitId, $unitCode, $quantity);
		$this->unitOfMeasure->insert($this->getPDO());
	}


	/**
	 * test inserting a valid Product and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$this->assertSame($pdoProducts->getVendorId(), $this->vendor->getVendorId());
		$this->assertSame($pdoProducts->getDescription(), $this->VALID_description);
		$this->assertSame($pdoProducts->getLeadTime(), $this->VALID_leadTime);
		$this->assertSame($pdoProducts->getSku(), $this->VALID_sku);
		$this->assertSame($pdoProducts->getTitle(), $this->VALID_title);
	}

	/**
	 * test inserting a Product that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProduct() {
		// create a product with a non null Product and watch it fail
		$product = new Product(InventoryTextTest::INVALID_KEY, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());
	}

	/**
	 * test inserting a Product, editing it, and then updating it
	 **/
	public function testUpdateValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Profile and insert to into mySQL
		$product = new Product (null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// edit the Product and update it in mySQL
		$product->setLeadTime($this->VALID_leadTime2);
		$product->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime2);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}

	/**
	 * test updating a Product that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidProduct() {
		// create a Product and try to update it without actually inserting it
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->update($this->getPDO());
	}

	/**
	 * test creating a Product and then deleting it
	 **/
	public function testDeleteValidProduct() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product (null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// delete the Product from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		$product->delete($this->getPDO());

		// grab the data from mySQL and enforce the Profile does not exist
		$pdoProduct = Product::getProductByProductId($this->getPDO(), $product->getProductId());
		$this->assertNull($pdoProduct);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("product"));
	}

	/**
	 * test deleting a Product that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProdcut() {
		// create a Product and try to delete it without actually inserting it
		$product = new Product (null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->delete($this->getPDO());
	}


	/**
	 * test grabbing a Product that does not exist
	 **/
	public function testGetInvalidProductByProductId() {
		// grab a Product id that exceeds the maximum allowable Product id
		$product = Product::getProductByProductId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($product);
	}


	/**
	 * test grabbing a Product by vendorId
	 **/
	public function testGetValidProductByVendorId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByVendorId($this->getPDO(), $product->getVendorId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}


	/**
	 * test grabbing a Product by description
	 **/
	public function testGetValidProductByDescription() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByDescription($this->getPDO(), $product->getDescription());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}


	/**
	 * test grabbing a Product by leadTime
	 **/
	public function testGetValidProductByLeadTIme() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByLeadTime($this->getPDO(), $product->getLeadTime());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}


	/**
	 * test grabbing a Product by sku
	 **/
	public function testGetValidProductBySku() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductBySku($this->getPDO(), $product->getSku());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}


	/**
	 * test grabbing a Product by title
	 **/
	public function testGetValidProductByTitle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByTitle($this->getPDO(), $product->getTitle());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}


	/**
	 * test grabbing product by locationId
	 **/
	public function testGetValidLocationByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		$quantity = 5.9;

		// create a new product and insert to into mySQL
		$productLocation = new ProductLocation( $this->location->getLocationId(), $this->vendor->getVendorId(), $this->unitOfMeasure->getUnitId(),
			$quantity);
		$productLocation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoLocationArray = Product::getLocationByProductId($this->getPDO(), $product->getProductId());
		for($i = 0; $i < count($pdoLocationArray); $i++) {
			if($i === 0) {
				$this->assertSame($pdoLocationArray[$i]->getDescription(), $this->VALID_description);
				$this->assertSame($pdoLocationArray[$i]->getSku(), $this->VALID_sku);
				$this->assertSame($pdoLocationArray[$i]->getTitle(), $this->VALID_title);

			} else {
				$this->assertSame($pdoLocationArray[$i]->getStorageCode(), $this->location->getLocationId());
				$this->assertSame($pdoLocationArray[$i]->getStorageCode(), $this->location->getStorageCode());
				$this->assertSame($pdoLocationArray[$i]->getDescription(), $this->location->getDescription());
			}
		}
	}

	/**
	 * test grabbing product by unit of measure
	 **/
	public function testGetValidUnitOfMeasurementByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		$quantity = 5.9;

		// create a new product and insert to into mySQL
		$productLocation = new ProductLocation( $this->location->getLocationId(), $this->vendor->getVendorId(), $this->unitOfMeasure->getUnitId(),
			$quantity);
		$productLocation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUnitOfMeasureArray = Product::getLocationByProductId($this->getPDO(), $product->getProductId());
		for($i = 0; $i < count($pdoUnitOfMeasureArray); $i++) {
			if($i === 0) {
				$this->assertSame($pdoUnitOfMeasureArray[$i]->getDescription(), $this->VALID_description);
				$this->assertSame($pdoUnitOfMeasureArray[$i]->getSku(), $this->VALID_sku);
				$this->assertSame($pdoUnitOfMeasureArray[$i]->getTitle(), $this->VALID_title);

			} else {
				$this->assertSame($pdoUnitOfMeasureArray[$i]->getStorageCode(), $this->unitOfMeasure->getUnitId());
				$this->assertSame($pdoUnitOfMeasureArray[$i]->getStorageCode(), $this->unitOfMeasure->getUnitCode());
				$this->assertSame($pdoUnitOfMeasureArray[$i]->getDescription(), $this->unitOfMeasure->getQuantity());
			}
		}
	}

	/**
	 * test grabbing product by finished product
	 **/
	public function testGetValidFinishedProductByProductId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		$quantity = 5.9; //what do I do here???

		// create a new product and insert to into mySQL
		$productLocation = new ProductLocation( $this->location->getLocationId(), $this->vendor->getVendorId(), $this->unitOfMeasure->getUnitId(),
			$quantity);
		$productLocation->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFinishedProductArray = Product::getLocationByProductId($this->getPDO(), $product->getProductId());
		for($i = 0; $i < count($pdoFinishedProductArray); $i++) {
			if($i === 0) {
				$this->assertSame($pdoFinishedProductArray[$i]->getDescription(), $this->VALID_description);
				$this->assertSame($pdoFinishedProductArray[$i]->getSku(), $this->VALID_sku);
				$this->assertSame($pdoFinishedProductArray[$i]->getTitle(), $this->VALID_title);

			} else {
				$this->assertSame($pdoFinishedProductArray[$i]->getStorageCode(), $this->finishedProduct->getFinishedProductId());
				$this->assertSame($pdoFinishedProductArray[$i]->getStorageCode(), $this->finishedProduct->getRawMaterialId());
				$this->assertSame($pdoFinishedProductArray[$i]->getDescription(), $this->finishedProduct->getRawQuantity());
			}
		}
	}

}






