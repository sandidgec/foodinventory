<div class="col-md-3">
	<img class="logo" src="" alt="">
</div>
<div class="col-md-9">
	<nav class="navbar">
		<div class="navbar-header">
			<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-menu">
				<span class="sr-only">Menu</span>
				<span class="glyphicon glyphicon-menu-hamburger"></span>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="main-menu">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#">Home</a></li>
				<li><a href="#">About</a></li>
				<li><?php require_once($PREFIX . "lib/angular/views/signup.php"); ?></li>
				<li><?php require_once($PREFIX . "lib/angular/views/login.php"); ?></li>
			</ul>
		</div>

	</nav>
</div>