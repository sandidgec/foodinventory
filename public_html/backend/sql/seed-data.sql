SELECT product.productId, product.vendorId, product.description, product.leadTime, product.sku, product.title,
	notification.notificationId, notification.alertId, notification.emailStatus, notification.notificationDateTime, notification.notificationHandle, notification.notificationContent
FROM product
	INNER JOIN productAlert ON product.productId = productAlert.productId
	INNER JOIN alertLevel ON productAlert.alertId = alertLevel.alertId
	INNER JOIN notification ON alertLevel.alertId = notification.alertId
WHERE notification.alertId = :alertId"
