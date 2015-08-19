<?php
/**
 * The Product class for Inventory
 *
 * This product class is a single class within the overall product for foodinventory
 *
 * @author Marie Vigil <marie@jtdesignsolutions>
 **/


class Product {
	/**
	 * id for this Product; this is the primary key
	 * @var string $productId
	 **/
	private $productId;
	/**
	 * id for the related Vendor; this is a foreign key
	 * @var string $vendorId
	 **/
	private $vendorId;
	/**
	 * textual description of this Product
	 * @var string $description
	 **/
	private $description;
	/**
	 * leadTime for this Product
	 * @var int $leadTime
	 **/
	private $leadTime;
	/**
	 * sku for this Product
	 * @var string $sku
	 **/
	private $sku;
	/**
	 * textual title of this Product
	 * @var string $title
	 **/
	private $title;


	/**
	 * constructor for this Product
	 *
	 * @param string $newProductId id for this Product
	 * @param string $newVendorId id for the related Vendor
	 * @param string $newDescription textual description of this Product
	 * @param int $newLeadTime leadTime for this Product
	 * @param string $newSku sku for this Product
	 * @param string $newTitle textual title of this Product
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 **/
	public function __construct($newProductId, $newVendorId, $newDescription, $newLeadTime, $newSku, $newTitle) {
		try {
			$this->setProductId($newProductId);
			$this->setVendorId($newVendorId);
			$this->setDescription($newDescription);
			$this->setLeadTime($newLeadTime);
			$this->setSku($newSku);
			$this->setTitle($newTitle);
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
	 * @return string value of product id
	 **/
	public function getProductId() {
		return ($this->productId);
	}

	/**
	 * mutator method for product id
	 *
	 * @param mixed $newProductId new value of product id
	 * @throws InvalidArgumentException if $newProductId is not a valid integer
	 * @throws RangeException if $newProductId is not positive
	 **/
	public function setProductId($newProductId) {
		// base case: if the product id is null, this a new product without a mySQL assigned id (yet)
		if($newProductId === null) {
			$this->productId = null;
			return;
		}

		// verify the product id is valid
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_STRING);
		if($newProductId === false) {
			throw(new InvalidArgumentException("product id is not a valid string"));
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
	 *
	 * @return string value of vendor id
	 **/
	public function getVendorId() {
		return ($this->vendorId);
	}

	/**
	 * mutator method for vendor id
	 *
	 * @param mixed $newVendorId new value of vendor id
	 * @throws InvalidArgumentException if $newVendorId is not a valid string
	 * @throws RangeException if $newVendorId is not positive
	 **/
	public function setVendorId($newVendorId) {
		// verify the vendor id is valid
		$newVendorId = filter_var($newVendorId, FILTER_VALIDATE_STRING);
		if($newVendorId === false) {
			throw(new InvalidArgumentException("vendor id is not a valid string"));
		}

		// verify the vendor id is positive
		if($newVendorId <= 0) {
			throw(new RangeException("vendor id is not positive"));
		}

		// convert and store the vendor id
		$this->vendorId = intval($newVendorId);
	}

	/**
	 * accessor method for description
	 *
	 * @return string value of description
	 **/
	public function getDescription() {
		return ($this->description);
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
			throw(new RangeException("description is too large"));
		}

		// store the description
		$this->description = $newDescription;
	}

	/**
	 * accessor method for leadTime
	 *
	 * @return int value of leadTime
	 **/
	public function getLeadTime() {
		return ($this->leadTime);
	}

	/**
	 * mutator method for leadTime
	 *
	 * @param int $newLeadTime new value of leadTime
	 * @throws InvalidArgumentException if $newLeadTime is not a valid integer
	 * @throws RangeException if $newLeadTime is not positive
	 **/
	public function setLeadTime($newLeadTime) {
		// verify the leadTime is valid
		$newLeadTime = filter_var($newLeadTime, FILTER_VALIDATE_INT);
		if($newLeadTime === false) {
			throw(new InvalidArgumentException("leadTime is not a valid integer"));
		}

		// verify the leadTime is positive
		if($newLeadTime < 0) {
			throw(new RangeException("leadTime is not positive"));
		}

		// convert and store the leadTime
		$this->leadTime = intval($newLeadTime);
	}

	/**
	 * accessor method for sku
	 *
	 * @return string value of sku
	 **/
	public function getSku() {
		return ($this->sku);
	}

	/**
	 * mutator method for sku
	 *
	 * @param string $newSku new value of sku
	 * @throws InvalidArgumentException if $newSku is not a string or insecure
	 * @throws RangeException if $newSku is > 64 characters
	 **/
	public function setSku($newSku) {
		// verify the sku is secure
		$newSku = trim($newSku);
		$newSku = filter_var($newSku, FILTER_SANITIZE_STRING);
		if(empty($newSku) === true) {
			throw(new InvalidArgumentException("sku is empty or insecure"));
		}

		// verify the description will fit in the database
		if(strlen($newSku) > 64) {
			throw(new RangeException("sku is too large"));
		}

		// store the description
		$this->sku = $newSku;
	}

	/**
	 * accessor method for title
	 *
	 * @return string value of title
	 **/
	public function getTitle() {
		return ($this->title);
	}

	/**
	 * mutator method for title
	 *
	 * @param string $newTitle new value of title
	 * @throws InvalidArgumentException if $newTitle is not a string or insecure
	 * @throws RangeException if $newTitle is > 32 characters
	 **/
	public function setTitle($newTitle) {
		// verify the title is secure
		$newTitle = trim($newTitle);
		$newTitle = filter_var($newTitle, FILTER_SANITIZE_STRING);
		if(empty($newTitle) === true) {
			throw(new InvalidArgumentException("title is empty or insecure"));
		}

		// verify the title will fit in the database
		if(strlen($newTitle) > 32) {
			throw(new RangeException("title is too large"));
		}

		// store the title
		$this->title = $newTitle;
	}


	/**
	 * determines which variables to include in json_encode()
	 *
	 * @see http://php.net/manual/en/class.jsonserializable.php JsonSerializable interface
	 * @return array all object variables, including private variables
	 **/
	public function JsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}


	/**
	 * inserts this Product into mySQL
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
		$query = "INSERT INTO product(vendorId, description, leadTime, sku, title) VALUES(:vendorId, :description, :leadTime, :sku, :title)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("vendorId" => $this->vendorId, "description" => $this->description, "leadTime" => $this->leadTime, "sku" => $this->sku, "title" => $this->title);
		$statement->execute($parameters);

		// update the null productId with what mySQL just gave us
		$this->productId = intval($pdo->lastInsertId());
	}

	/**
	 * updates this Product in mySQL
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
		$query = "UPDATE product SET vendorId = :vendorId, description = :description, leadTime = :leadTime , sku = :sku, title = :title WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("vendorId" => $this->vendorId, "description" => $this->description, "leadTime" => $this->leadTime, "sku" => $this->sku, "title" => $this->title, "productId" => $this->productId);
		$statement->execute($parameters);
	}


	/**
	 * deletes this Product from mySQL
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
		$query = "DELETE FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("productId" => $this->productId);
		$statement->execute($parameters);
	}

	/**
	 * gets the Product by productId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newProductId the product id to search for
	 * @return mixed Product found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByProductId(PDO &$pdo, $newProductId) {
		// sanitize the productId before searching
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_STRING);
		if($newProductId === false) {
			throw(new PDOException("product id is not an string"));
		}
		if($newProductId <= 0) {
			throw(new PDOException("product id is not positive"));
		}

		// create query template
		$query = "SELECT productId, vendorId, description, leadTime, sku, title FROM product WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the product id to the place holder in the template
		$parameters = array("productId" => $newProductId);
		$statement->execute($parameters);

		// grab the product from mySQL
		try {
			$product = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$product = new Product($row["productId"], $row["vendorId"], $row["description"], $row["leadTime"], $row["sku"], $row["title"]);
			}
		} catch(PDOException $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($product);
	}


	/**
	 * gets the Product by vendorId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newVendorId the vendor id to search for
	 * @return SplFixedArray all products found for this vendorId
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByVendorId(PDO &$pdo, $newVendorId) {
		// sanitize the vendorId before searching
		$newVendorId = filter_var($newVendorId, FILTER_VALIDATE_INT);
		if($newVendorId === false) {
			throw(new PDOException("vendor id is not an integer"));
		}
		if($newVendorId <= 0) {
			throw(new PDOException("vendor id is not positive"));
		}

		// create query template
		$query = "SELECT productId, vendorId, description, leadTime, sku, title FROM product WHERE vendorId = :vendorId";
		$statement = $pdo->prepare($query);

		// bind the vendorId to the place holder in the template
		$parameters = array("vendorId" => $newVendorId);
		$statement->execute($parameters);

		// build an array of Product(s)
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["description"], $row["leadTime"], $row["sku"], $row["title"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($products);
	}

	/**
	 * gets the Product by description
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $newDescription the product description to search for
	 * @return SplFixedArray all Product(s) found for this description
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByDescription(PDO &$pdo, $newDescription) {
		// sanitize the description before searching
		$newDescription = trim($newDescription);
		$newDescription = filter_var($newDescription, FILTER_SANITIZE_STRING);
		if(empty($newDescription) === true) {
			throw(new PDOException("description is invalid"));
		}

		// create query template
		$query = "SELECT productId, vendorId, description, leadTime, sku, title FROM product WHERE description LIKE :description";
		$statement = $pdo->prepare($query);

		// bind the product description to the place holder in the template
		$parameters = array("description" => $newDescription);
		$statement->execute($parameters);

		// build an array of Product(s)
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["description"], $row["leadTime"], $row["sku"], $row["title"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($products);
	}

	/**
	 * gets the Product by leadTime
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newLeadTime the product leadTime to search for
	 * @return SplFixedArray all Product(s) found for this leadTime
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByLeadTime(PDO &$pdo, $newLeadTime) {
		// sanitize the leadTime before searching
		$newLeadTime = filter_var($newLeadTime, FILTER_VALIDATE_INT);
		if($newLeadTime === false) {
			throw(new PDOException("leadTime is not an integer"));
		}
		if($newLeadTime <= 0) {
			throw(new PDOException("leadTime is not positive"));
		}

		// create query template
		$query = "SELECT productId, vendorId, description, leadTime, sku, title FROM product WHERE leadTime = :leadTime";
		$statement = $pdo->prepare($query);

		// bind the leadTime to the place holder in the template
		$parameters = array("leadTime" => $newLeadTime);
		$statement->execute($parameters);

		// build an array of Product(s)
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["description"], $row["leadTime"], $row["sku"], $row["title"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($products);
	}

	/**
	 * gets the Product by sku
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $newSku the sku to search for
	 * @return SplFixedArray all Product(s) found for this sku
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductBySku(PDO &$pdo, $newSku) {
		// sanitize the sku before searching
		$newSku = trim($newSku);
		$newSku = filter_var($newSku, FILTER_SANITIZE_STRING);
		if(empty($newSku) === true) {
			throw(new PDOException("sku is invalid"));
		}

		// create query template
		$query = "SELECT productId, vendorId, description, leadTime, sku, title FROM product WHERE sku LIKE :sku";
		$statement = $pdo->prepare($query);

		// bind the sku to the place holder in the template
		$parameters = array("sku" => $newSku);
		$statement->execute($parameters);

		// build an array of Product(s)
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["description"], $row["leadTime"], $row["sku"], $row["title"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($products);
	}

	/**
	 * gets the Product by title
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $newTitle the product title to search for
	 * @return SplFixedArray all Product(s) found for this title
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByTitle(PDO &$pdo, $newTitle) {
		// sanitize the title before searching
		$newTitle = trim($newTitle);
		$newTitle = filter_var($newTitle, FILTER_SANITIZE_STRING);
		if(empty($newTitle) === true) {
			throw(new PDOException("title is invalid"));
		}

		// create query template
		$query = "SELECT productId, vendorId, description, leadTime, sku, title FROM product WHERE title LIKE :title";
		$statement = $pdo->prepare($query);

		// bind the title to the place holder in the template
		$parameters = array("title" => $newTitle);
		$statement->execute($parameters);

		// build an array of Product(s)
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["description"], $row["leadTime"], $row["sku"], $row["title"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($products);
	}

	/**
	 * gets the Product by pagination
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $page the page of results the viewer is on
	 * @return SplFixedArray all products found for this pagination
	 * @throws PDOException when mySQL related errors occur
	 **/

	public static function getAllProducts(PDO &$pdo, $page) {
		// number of results per page
		$page = filter_var($page, FILTER_VALIDATE_INT);
		$pageSize = 25;
		$start = $page * $pageSize;

		// create query template
		$query = "SELECT productId, vendorId, description, leadTime, sku, title FROM product ORDER BY productId
			LIMIT :start, :pageSize";
		$statement = $pdo->prepare($query);
		$statement->bindParam(":start", $start, PDO::PARAM_INT);
		$statement->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
		$statement->execute();

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["vendorId"], $row["description"], $row["leadTime"], $row["sku"],
					$row["title"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($products);
	}
}