<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8" />
		<title>"Inventory Text" Epic</title>
		<link rel="stylesheet" type="text/css" href="../css/styles.css" />
	</head>
	<body>
		<div class="container">
			<header>
				<h1>
					<strong>Epic: </strong>
					"Inventory Text"
				</h1>
				<nav>
					<ul>
						<li><a href="../index.php">Home</a></li>
						<li><a href="persona1.php">Persona 1</a></li>
						<li><a href="persona2.php">Persona 2</a></li>
						<li><a href="persona3.php">Persona 3</a></li>
						<li><a href="wireframes.php">Wireframes</a></li>
					</ul>
				</nav>
			</header>
			<main>
				<h2>Conceptual Schematic</h2>
				<div class="schema">
					<h3>User to Movement; Movement to User</h3>
					<p>one user can have many movements</p>
					<p>one movement can have one and only one user</p>
					<h3>Movement to Product; Product to Movement</h3>
					<p>one movement can have many products</p>
					<p>one product can have one and only one movement</p>
					<h3>Movement to Location; Location to Movement</h3>
					<p>one movement can have many locations</p>
					<p>one location can have one and only one movement</p>
					<h3>Movement to productLocation; productLocation to Movement</h3>
					<p>one movement can have many productLocations</p>
					<p>one productLocation can have one and only one movement</p>

					<h3>Product to Location; Location to Product</h3>
					<p>one product can have many locations</p>
					<p>one location can have many products</p>
					<h3>Product to productLocation; productLocation to Product</h3>
					<p>one product can have one and only one productLocation</p>
					<p>one productLocation can have many products</p>
					<h3>Location to productLocation; productLocation to Location</h3>
					<p>one location can have one and only one productLocation</p>
					<p>one productLocation can have many locations</p>
				</div>
				<h2>Inventory Text ERD:</h2>
				<img src="../images/inventory-text.jpg" alt="Inventory Text ERD" width="1000"/>

				<h2>System Goals</h2>
				<p> The main focus of "Inventory Text" is to fill a gap for small business owners that could use an
					inventory system that acts as an extra employee. By responding intuitively via text and a web application,
					the software will give the business owner accurate and prompt information so that they can
					reorder items before running out, decide what has been most popular among the inventory and see
					what items need to be promoted or price adjusted due to low sales. The software will also keep track of raw
					materials and send alerts based on user preference so that no time or money is lost due to lack of resources </p>
			</main>
		</div>
	</body>
</html>