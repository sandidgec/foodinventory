<div class="headtext"><span class="inv">Inventory</span><span class="text">TEXT</span></div>

<nav class="navbar pull-right main-menu">
	<div class="navbar-header">
		<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-menu">
			<span class="sr-only">Menu</span>
			<span class="glyphicon glyphicon-menu-hamburger"></span>
		</button>
	</div>

	<div class="collapse navbar-collapse" id="main-menu">
		<ul class="nav navbar-nav navbar-right">
			<li><a href="../lib/angular/views/admin-panel.php">Admin Panel</a></li>
			<li><a href="#">Home</a></li>
			<li><a href="#">About</a></li>
			<li><?php require_once($PREFIX . "lib/angular/views/signup.php"); ?></li>
			<li><?php require_once($PREFIX . "lib/angular/views/login.php"); ?></li>
		</ul>
	</div>
</nav>
