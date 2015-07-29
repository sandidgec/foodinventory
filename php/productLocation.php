<?php

/**
 * The productLocation class for inventoryText
 *
 * This class will attach a location to each individual item
 * multi-line
 *
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class productLocation {
	/**
	 * id for the location; this is a foreign key
	 * @var int $locationId
	 **/
	private $locationId;

	/**
	 * id for the product; this is a foreign key
	 * @var int $productId
	 **/
	private $productId;

	/**
	 * id for the units of the product; this is a foreign key
	 * @var int $unitId
	 **/
	private $unitId;

	/**
	 * number of products at the location
	 * @var int $quantity
	 **/
	private $quantity;
}