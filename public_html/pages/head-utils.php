<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

/**
 * Get the relative path.
 * @see https://raw.githubusercontent.com/kingscreations/farm-to-you/master/php/lib/_header.php FarmToYou Header
 **/
require_once(dirname(__DIR__) . "/root-path.php");
$CURRENT_DEPTH = substr_count($CURRENT_DIR, "/");
$ROOT_DEPTH = substr_count($ROOT_PATH, "/");
$DEPTH_DIFFERENCE = $CURRENT_DEPTH - $ROOT_DEPTH;
$PREFIX = str_repeat("../", $DEPTH_DIFFERENCE);
?>



<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>

<!-- Bootstrap Latest compiled and minified CSS -->
<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>

<!-- Optional Bootstrap theme -->
<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"
		rel="stylesheet"/>

<!-- LINK TO YOUR CUSTOM CSS FILES HERE -->
<link type="text/css" href="<?php echo $PREFIX ?>lib/css/forms.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo $PREFIX ?>lib/css/launch.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo $PREFIX ?>lib/css/animate.css" rel="stylesheet"/>


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script type="text/javascript" src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script type="text/javascript" src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript, all compiled plugins included -->
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!-- angular.js -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
<script type="text/javascript"
		  src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular-messages.min.js"></script>
<script type="text/javascript"
		  src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.min.js"></script>

<script type="text/javascript" src="<?php echo $PREFIX?>lib/angular/food-inventory.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX?>lib/angular/services/signup.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX?>lib/angular/controllers/signup.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX?>lib/angular/services/login.js"></script>
<script type="text/javascript" src="<?php echo $PREFIX?>lib/angular/controllers/login.js"></script>


