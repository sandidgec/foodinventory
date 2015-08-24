INSERT INTO vendor(vendorId, contactName, vendorEmail, vendorName, vendorPhoneNumber)
VALUES(1, "Kenny Chavez", "kenny@generalisimo.com.cl", "Generalismo Enterprises", "2125551212");
INSERT INTO product(productId, vendorId, description, leadTime, sku, title)
VALUES(2, 1, "MacBook Pro", 1, "MBP-TOO-MUCH", "ALL NEW MacBook Pro");
INSERT INTO alertLevel(alertId, alertCode, alertFrequency, alertOperator, alertPoint)
VALUES(3, "OS", "OK", "<", 1.0);
INSERT INTO notification(notificationId, alertId, emailStatus, notificationContent, notificationDateTime, notificationHandle)
VALUES(4, 3, 0, "laptops are now too expensive", NOW(), "5055551212");
INSERT INTO productAlert(productId, alertId, alertEnabled)
VALUES(2, 3, 1);

SELECT product.productId, product.vendorId, product.description, product.leadTime, product.sku, product.title,
	notification.notificationId, notification.alertId, notification.emailStatus, notification.notificationDateTime, notification.notificationHandle, notification.notificationContent
FROM product
	INNER JOIN productAlert ON product.productId = productAlert.productId
	INNER JOIN alertLevel ON productAlert.alertId = alertLevel.alertId
	INNER JOIN notification ON alertLevel.alertId = notification.alertId
WHERE notification.alertId = :alertId"
