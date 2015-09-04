<?php

if(isset($_POST["submit"])) {

	$email = $_POST['email'];

	$from = 'Interested in Inventory Text';
	$to = 'info@inventorytext.com';
	$subject = "Request for more info";

	$body = "Email: $email";

	// If there are no errors, send the email
	if(!isset($errName) && !isset($errEmail)) {
		if(mail($to, $subject, $body, $from)) {
			$result = '<div>Thank You!</div>';
		} else {
			$result = '<div class="text-danger">There was an error sending your message. Please try again later.</div>';
		}
	}
}
?>
<div id="contact" class="contact">
	<div class="contact-box">
		<h3 class="contact-header">
			Request more information today!
		</h3>

		<form class="form-horizontal" role="form" method="post" action="contact.php#contact">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="form-group ">
					<label for="email" class="col-sm-2 control-label">Email</label>

					<div class="col-sm-8">
						<input type="email" class="form-control" id="email" name="email"
								 placeholder="email@example.com" value="">
						<?php if(isset($errEmail)) {
							echo "<p class='text-danger'>$errEmail</p>";
						} ?>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<input id="submit" name="submit" type="submit" value="Send" class="btn contact-button">
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<?php if(isset($result)) {
						echo $result;
					} ?>
				</div>
			</div>
		</form>
	</div>
</div>