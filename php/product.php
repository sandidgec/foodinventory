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
	 * id for the Description of the product; this is a foreign key
	 * @var int $descriptionId
	 **/
	private $descriptionId;

	/**
	 * constructor for this Product
	 *
	 * @param mixed $newProductId id of this Product or null if a new Product
	 * @param int $newDescriptionId id of the Description for this Product
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 **/
	public function __construct($newProductId, $newDescriptionId = null) {
		try {
			$this->setProductId($newProductId);
			$this->setDescriptionId($newDescriptionId);
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




?>