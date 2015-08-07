<?php
/**
 * Product class for foodinventory
 *
 * This product class is a single class within the overall product for foodinventory
 *
 * @author Marie Vigil <marie@jtdesignsolutions>
 *
 **/

class Product {
	/**
	 * id for this Product; this is the primary key
	 * @var int $productId
	 **/
	private $productId;
	/**
	 * id for the related vendor; this is a foreign key
	 * @var int $vendorId
	 **/
	private $vendorId;
	/**
	 * sku for this Product
	 * @var int $sku
	 **/
	private $sku;
	/**
	 * leadTime for this Product
	 * @var int $leadTime
	 **/
	private $leadTime;
	/**
	 * actual textual title of this Product
	 * @var string $title
	 **/
	private $title;
	/**
	 * actual textual description of this Product
	 * @var string $description
	 **/
	private $description;



	/**
	 * constructor for this Product
	 *
	 * @param int $newProductId id of this Product
	 * @param int $newVendorId id of this Product vendor
	 * @param int $newSku string containing actual product Sku
	 * @param int $newLeadTime int containing actual product leadTime
	 * @param string $newTitle string containing actual product Title
	 * @param string $newDescription string containing actual product Description

	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 **/
	public function __construct($newProductId, $newVendorId, $newSku, $newLeadTime, $newTitle, $newDescription) {
		try {
			$this->setProductId($newProductId);
			$this->setVendorId($newVendorId);
			$this->setSku($newSku);
			$this->setLeadTime($newLeadTime);
			$this->setTitle($newTitle);
			$this->setDescription($newDescription);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			// rethrow generic exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for product id
	 *
	 * @return int value of product id
	 **/
	public function getProductId() {
		return($this->productId);
	}

	/**
	 * mutator method for product id
	 *
	 * @param mixed $newProductId new value of product id
	 * @throws InvalidArgumentException if $newProductId is not an integer
	 * @throws RangeException if $newProductId is not positive
	 **/
	public function setProductId($newProductId) {
		// base case: if the product id is null, this a new product without a mySQL assigned id (yet)
		if($newProductId === null) {
			$this->productId = null;
			return;
		}

		// verify the product id is valid
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new InvalidArgumentException("product id is not a valid integer"));
		}

		// verify the product id is positive
		if($newProductId <= 0) {
			throw(new RangeException("product id is not positive"));
		}

		// convert and store the product id
		$this->productId = intval($newProductId);
	}

	/**
	 * accessor method for vendor id
	 * @return int value of vendor id
	 **/
	public function getVendorId() {
		return($this->vendorId);
	}

	/**
	 * mutator method for vendor id
	 *
	 * @param mixed $newVendorId new value of vendor id
	 * @throws InvalidArgumentException if $newVendorId is not an integer
	 * @throws RangeException if $newVendorId is not positive
	 **/
	public function setVendorId($newVendorId) {
		// verify the vendor id is valid
		$newVendorId = filter_var($newVendorId, FILTER_VALIDATE_INT);
		if($newVendorId === false) {
			throw(new InvalidArgumentException("vendor id is not a valid integer"));
		}

		// verify the vendor id is positive
		if($newVendorId <= 0) {
			throw(new RangeException("vendor id is not positive"));
		}

		// convert and store the vendor id
		$this->vendorId = intval($newVendorId);
	}

	/**
	 * accessor method for sku
	 * @return int value of sku
	 **/
	public function getSku() {
		return($this->sku);
	}

	/**
	 * mutator method for sku
	 *
	 * @param mixed $newSku new value of sku
	 * @throws InvalidArgumentException if $newSku is not an integer
	 * @throws RangeException if $newSku is not positive
	 **/
	public function setSku($newSku) {
		// base case: if the sku is null, this a new sku without a mySQL assigned id (yet)
		if($newSku === null) {
			$this->sku = null;
			return;
		}

		// verify the sku is valid
		$newSku = filter_var($newSku, FILTER_VALIDATE_INT);
		if($newSku === false) {
			throw(new InvalidArgumentException("sku is not a valid integer"));
		}

		// verify the sku is positive
		if($newSku <= 0) {
			throw(new RangeException("sku is not positive"));
		}

		// convert and store the sku
		$this->sku = intval($newSku);
	}

	/**
	 * accessor method for leadTime
	 *
	 * @return int value of leadTime
	 **/
	public function getLeadTime() {
		return($this->leadTime);
	}

	/**
	 * mutator method for leadTime
	 *
	 * @param mixed $newLeadTime new value of leadTime
	 * @throws InvalidArgumentException if $newLeadTime is not an integer
	 * @throws RangeException if $newLeadTime is not positive
	 **/
	public function setLeadTime($newLeadTime) {
		// verify the leadTime is valid
		$newLeadTime = filter_var($newLeadTime, FILTER_VALIDATE_INT);
		if($newLeadTime === false) {
			throw(new InvalidArgumentException("leadTime is not a valid integer: " . $newLeadTime));
		}

		// verify the leadTime is positive
		if($newLeadTime < 0) {
			throw(new RangeException("leadTime is not positive"));
		}

		// convert and store the leadTime
		$this->leadTime = intval($newLeadTime);
	}


	/**
	 * accessor method for title
	 *
	 * @return string value of title
	 **/
	public function getTitle() {
		return($this->title);
	}

	/**
	 * mutator method for title
	 *
	 * @param string $newTitle new value of title
	 * @throws InvalidArgumentException if $newTitle is not a string or insecure
	 * @throws RangeException if $newTitle is > 100 characters
	 **/
	public function setTitle($newTitle) {
		// verify the title is secure
		$newTitle = trim($newTitle);
		$newTitle = filter_var($newTitle, FILTER_SANITIZE_STRING);
		if(empty($newTitle) === true) {
			throw(new InvalidArgumentException("title is empty or insecure"));
		}

		// verify the title will fit in the database
		if(strlen($newTitle) > 128) {
			throw(new RangeException("title too large"));
		}

		// store the title
		$this->title = $newTitle;
	}


	/**
	 * accessor method for description
	 *
	 * @return string value of description
	 **/
	public function getDescription() {
		return($this->description);
	}

	/**
	 * mutator method for description
	 *
	 * @param string $newDescription new value of description
	 * @throws InvalidArgumentException if $newDescription is not a string or insecure
	 * @throws RangeException if $newDescription is > 128 characters
	 **/
	public function setDescription($newDescription) {
		// verify the description is secure
		$newDescription = trim($newDescription);
		$newDescription = filter_var($newDescription, FILTER_SANITIZE_STRING);
		if(empty($newDescription) === true) {
			throw(new InvalidArgumentException("description is empty or insecure"));
		}

		// verify the description will fit in the database
		if(strlen($newDescription) > 128) {
			throw(new RangeException("description too large"));
		}

		// store the description
		$this->description = $newDescription;
	}


	/**
	 * inserts this product into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
		// enforce the productId is null (i.e., don't insert a product that already exists)
		if($this->productId !== null) {
			throw(new PDOException("not a new product"));
		}

		// create query template
		$query	 = "INSERT INTO product(vendorId, sku, leadTime, title, description) VALUES(:vendorId, :sku, :leadTime, :title, :description)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("vendorId" => $this->vendorId, "sku" => $this->sku, "leadTime" => $this->leadTime, "title" => $this->title, "description" => $this->description);
		$statement->execute($parameters);

		// update the null ProductId with what mySQL just gave us
		$this->productId = intval($pdo->lastInsertId());
	}


	/**
	 * deletes this product from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$pdo) {
		// enforce the ProductId is not null (i.e., don't delete a product that hasn't been inserted)
		if($this->productId === null) {
			throw(new PDOException("unable to delete a product that does not exist"));
		}

		// create query template
		$query	 = "DELETE FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("productId" => $this->productId);
		$statement->execute($parameters);
	}

	/**
	 * updates this product in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$pdo) {
		// enforce the ProductId is not null (i.e., don't update a product that hasn't been inserted)
		if($this->productId === null) {
			throw(new PDOException("unable to update a product that does not exist"));
		}

		// create query template
		$query	 = "UPDATE product SET vendorId = :vendorId, sku = :sku, leadTime = :leadTime , title = :title , description = :description WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("vendorId" => $this->vendorId, "sku" => $this->sku, "leadTime" => $this->leadTime, "title" => $this->title, "description" => $this->description, "productId" => $this->productId);
		$statement->execute($parameters);
	}

	/**
	 * gets the product by productId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $productId product id to search for
	 * @return mixed product found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByProductId(PDO &$pdo, $newProductId) {
		// sanitize the productId before searching
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new PDOException("product id is not an integer"));
		}
		if($newProductId <= 0) {
			throw(new PDOException("product id is not positive"));
		}

		// create query template
		$query	 = "SELECT productId, vendorId, sku, leadTime, title, description FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the product id to the place holder in the template
		$parameters = array("productId" => $newProductId);
		$statement->execute($parameters);

		// grab the product from mySQL
		try {
			$product = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($product);
	}


	/**
	 * gets the product by vendorId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $vendorId content to search for
	 * @return SplFixedArray all product found for this vendorId
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByVendorId(PDO &$pdo, $newVendorId) {
		// sanitize the vendorId before searching
		$newVendorId = trim($newVendorId);
		$newVendorId = filter_var($newVendorId, FILTER_SANITIZE_STRING);
		if(empty($newVendorId) === true) {
			throw(new PDOException("vendorId is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, vendorId, sku, leadTime, title, description FROM product WHERE vendorId LIKE :vendorId";
		$statement = $pdo->prepare($query);

		// bind the vendorId to the place holder in the template
		$parameters = array("vendorId" => $newVendorId);
		$statement->execute($parameters);

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"],$row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($products);
	}


	/**
	 * gets the product by sku
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $sku content to search for
	 * @return SplFixedArray all product found for this sku
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductBySku(PDO &$pdo, $sku) {
		// sanitize the sku before searching
		$sku = trim($sku);
		$sku = filter_var($sku, FILTER_SANITIZE_STRING);
		if(empty($sku) === true) {
			throw(new PDOException("sku is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, vendorId, sku, leadTime, title, description FROM product WHERE sku LIKE :sku";
		$statement = $pdo->prepare($query);

		// bind the sku to the place holder in the template
		$parameters = array("sku" => $sku);
		$statement->execute($parameters);

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($products);
	}

	/**
	 * gets the product by leadTime
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $leadTime content to search for
	 * @return SplFixedArray all product found for this leadTime
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByLeadTIme(PDO &$pdo, $leadTime) {
		// sanitize the leadTime before searching
		$leadTime = trim($leadTime);
		$leadTime = filter_var($leadTime, FILTER_SANITIZE_STRING);
		if(empty($leadTime) === true) {
			throw(new PDOException("leadTIme is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, vendorId, sku, leadTime, title, description FROM product WHERE leadTime LIKE :leadTime";
		$statement = $pdo->prepare($query);

		// bind the leadTime to the place holder in the template
		$parameters = array("leadTime" => $leadTime);
		$statement->execute($parameters);

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($products);
	}

	/**
	 * gets the product by title
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $title product content to search for
	 * @return SplFixedArray all product found for this title
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByTitle(PDO &$pdo, $title) {
		// sanitize the title before searching
		$title = trim($title);
		$title = filter_var($title, FILTER_SANITIZE_STRING);
		if(empty($title) === true) {
			throw(new PDOException("title is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, vendorId, sku, leadTime, title, description FROM product WHERE title LIKE :title";
		$statement = $pdo->prepare($query);

		// bind the title to the place holder in the template
		$parameters = array("title" => $title);
		$statement->execute($parameters);

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($products);
	}



	/**
	 * gets the product by description
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $description product content to search for
	 * @return SplFixedArray all product found for this description
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByDescription(PDO &$pdo, $description) {
		// sanitize the description before searching
		$description = trim($description);
		$description = filter_var($description, FILTER_SANITIZE_STRING);
		if(empty($description) === true) {
			throw(new PDOException("description is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, vendorId, sku, leadTime, title, description FROM product WHERE description LIKE :description";
		$statement = $pdo->prepare($query);

		// bind the product description to the place holder in the template
		$parameters = array("description" => $description);
		$statement->execute($parameters);

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($products);
	}
}


?>