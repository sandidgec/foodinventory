<?php
/**
 * this is the alertLevel class for the inventoryText capstone project
 *
 * this alertLevel class will configure the user preferences for alerts, including how oftern and what the alert tells
 * the customer.
 *
 * @author James Huber <jhuber8@cnm.edu>
 **/
class AlertLevel {
	/**
	 * id for this alert level class, this is the primary key
	 * @var int $alertId
	 **/
	private $alertId;
	/**
	 *this is the alert type
	 * @var string $alertCode
	 */
	private $alertCode;
	/**
	 *this tells how often an alert will be sent to user
	 * @var string $alertFrequency
	 */
	private $alerFrequency;
	/**
	 *this is the quantity at which the user will receive an alert (set by user)
	 * @var int $alertLevel
	 */
	private $alertLevel;
}