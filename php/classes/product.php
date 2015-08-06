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
	 * @var string $sku
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
	 * @param string $newSku string containing actual product Sku
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
			$this->setLeadTime($newTitle);
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
	 *
	 * @return int value of vendor id
	 **/
	public function getVendorId() {
		return($this->vendorId);
	}

	/**
	 * mutator method for vendorId
	 *
	 * @param string $newVendor new value of description
	 * @throws InvalidArgumentException if $newVendor is not a string or insecure
	 * @throws RangeException if $newVendor is > 128 characters
	 **/
	public function setVendor($newVendor) {
		// verify the vendor is secure
		$newVendor = trim($newVendor);
		$newVendor = filter_var($newVendor, FILTER_SANITIZE_STRING);
		if(empty($newVendor) === true) {
			throw(new InvalidArgumentException("vendor is empty or insecure"));
		}

		// verify the vendor will fit in the database
		if(strlen($newVendor) > 128) {
			throw(new RangeException("vendor too large"));
		}

		// store the vendor
		$this->description = $newVendor;
	}

	/**
	 * accessor method for sku
	 *
	 * @return string value of sku
	 */
	public function getSku() {
		return $this->sku;
	}

	/**
	 * mutator method for sku
	 *
	 * @param string $newSku
	 * @throws InvalidArgumentException if $newSku is not a string
	 * @throws RangeException if $newSku is greater than 128 characters
	 */
	public function setSku($newSku) {
		// verify the sku is secure
		$newSku = trim($newSku);
		$newSku = filter_var($newSku, FILTER_SANITIZE_STRING);
		if(empty($newSku) === true) {
			throw(new InvalidArgumentException("sku is empty or insecure"));
		}

		// verify the sku will fit in the database
		if(strlen($newSku) > 64) {
			throw(new RangeException("sku is too large"));
		}

		// store the sku
		$this->sku = $newSku;
	}


	/**
	 * accessor method for leadTime
	 *
	 * @return string value of leadTime
	 **/
	public function getLeadTime() {
		return($this->leadTime);
	}

	/**
	 * mutator method for leadTime
	 *
	 * @param int $newLeadTime new value of leadTime
	 * @throws InvalidArgumentException if $newLeadTime is not a int or insecure
	 * @throws RangeException if $newLeadTime is > 3
	 **/
	public function setLeadTime($newLeadTime) {
		// verify the leadTime is secure
		$newLeadTime = trim($newLeadTime);
		$newLeadTime = filter_var($newLeadTime, FILTER_SANITIZE_STRING);
		if(empty($newLeadTime) === true) {
			throw(new InvalidArgumentException("leadTime is empty or insecure"));
		}

		// verify the leadTime will fit in the database
		if(strlen($newLeadTime) > 3) {
			throw(new RangeException("leadTime too large"));
		}

		// store the leadTime
		$this->leadTime = $newLeadTime;
	}


	/**
	 * accessor method for title
	 *
	 * @return string value of titile
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
		if(strlen($newTitle) > 100) {
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
		$query	 = "INSERT INTO product(vendorId, sku, leadTime, title, description) VALUES(:productId, :vendorId, :sku, :leadTime, :title, :description)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("productId" => $this->productId, "vendorId" => $this->vendorId, "sku" => $this->sku, "leadTime" => $this->leadTime, "title" => $this->title, "description" => $this->description);
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
		$query	 = "SELECT productId, userId, vendorId, sku, leadTime, title, description FROM product WHERE productId = :productId";
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
				$product = new Product($row["productId"], $row["userId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($product);
	}

	/**
	 * gets the product by userId
	 * userId is a join element from productPermission class
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $userId content to search for
	 * @return SplFixedArray all product found for this userId
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByUserId(PDO &$pdo, $newUserId, $userId) {
		// sanitize the userId before searching
		$newUserId = trim($newUserId);
		$newUserId = filter_var($newUserId, FILTER_SANITIZE_STRING);
		if(empty($newUserId) === true) {
			throw(new PDOException("userId is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, userId, vendorId, sku, leadTime, title, description FROM product WHERE userId LIKE :userId";
		$statement = $pdo->prepare($query);

		// bind the userId to the place holder in the template
		$parameters = array("userId" => $userId);
		$statement->execute($parameters);

		// build an array of userIds
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["userId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
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
		$query	 = "SELECT productId, userId, vendorId, sku, leadTime, title, description FROM product WHERE userId LIKE :userId";
		$statement = $pdo->prepare($query);

		// bind the vendorId to the place holder in the template
		$parameters = array("vendorId" => $vendorId);
		$statement->execute($parameters);

		// build an array of userIds
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["userId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
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
	public static function getProductBySku(PDO &$pdo, $newSku, $sku) {
		// sanitize the sku before searching
		$newSku = trim($newSku);
		$newSku = filter_var($newSku, FILTER_SANITIZE_STRING);
		if(empty($newSku) === true) {
			throw(new PDOException("sku is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, userId, vendorId, sku, leadTime, title, description FROM product WHERE userId LIKE :userId";
		$statement = $pdo->prepare($query);

		// bind the sku to the place holder in the template
		$parameters = array("sku" => $sku);
		$statement->execute($parameters);

		// build an array of sku
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["userId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
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
	public static function getProductByLeadTIme(PDO &$pdo, $newLeadTIme, $leadTime) {
		// sanitize the leadTime before searching
		$newleadTime = trim($newLeadTIme);
		$newLeadTIme = filter_var($newLeadTIme, FILTER_SANITIZE_STRING);
		if(empty($newLeadTIme) === true) {
			throw(new PDOException("leadTIme is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, userId, vendorId, sku, leadTime, title, description FROM product WHERE userId LIKE :userId";
		$statement = $pdo->prepare($query);

		// bind the sku to the place holder in the template
		$parameters = array("leadTime" => $leadTime);
		$statement->execute($parameters);

		// build an array of leadTime
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["userId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
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
	public static function getProductByTitle(PDO &$pdo, $newTitle, $title) {
		// sanitize the title before searching
		$newTitle = trim($newTitle);
		$newTitle = filter_var($newTitle, FILTER_SANITIZE_STRING);
		if(empty($newTitle) === true) {
			throw(new PDOException("title is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, userId, vendorId, sku, leadTime, title, description FROM product WHERE description LIKE :description";
		$statement = $pdo->prepare($query);

		// bind the product description to the place holder in the template
		$parameters = array("title" => $title);
		$statement->execute($parameters);

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["userId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
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
	public static function getProductByDescription(PDO &$pdo, $newDescription, $description) {
		// sanitize the description before searching
		$newDescription = trim($newDescription);
		$newDescription = filter_var($newDescription, FILTER_SANITIZE_STRING);
		if(empty($newDescription) === true) {
			throw(new PDOException("description is invalid"));
		}

		// create query template
		$query	 = "SELECT productId, userId, vendorId, sku, leadTime, title, description FROM product WHERE description LIKE :description";
		$statement = $pdo->prepare($query);

		// bind the product description to the place holder in the template
		$parameters = array("description" => $description);
		$statement->execute($parameters);

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$product = new Product($row["productId"], $row["userId"], $row["vendorId"], $row["sku"], $row["leadTime"], $row["title"], $row["description"]);
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