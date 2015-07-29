<?php

/**
 * The movement class for inventoryText
 *
 * This class will monitor the movement of products in and
 * out of the inventory as well as the movement within inventory
 *
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class Movement {
	/**
	 * id for this Movement; this is the primary key
	 * @var int $movementId
	 **/
	private $movementId;

	/**
	 * id for the product's current location; this is a foreign key
	 * @var int $fromLocationId
	 **/
	private $fromLocationId;

	/**
	 * id for the product's new location; this is a foreign key
	 * @var int $toLocationId
	 **/
	private $toLocationId;

	/**
	 * id for the product being moved; this is a foreign key
	 * @var int $productId
	 **/
	private $productId;

	/**
	 * id for the units being moved; this is a foreign key
	 * @var int $unitId
	 **/
	private $unitId;

	/**
	 * cost of the product being moved
	 * @var double $cost
	 **/
	private $cost;

	/**
	 * the date of the movement
	 * @var string $movementDate
	 **/
	private $movementDate;

	/**
	 * the type of the movement;
	 * - M for Move
	 * - S for Sold
	 * - T for Trashed
	 * @var string $movementType
	 **/
	private $movementType;

	/**
	 * price of the product being moved
	 * @var double $price
	 **/
	private $price;
}