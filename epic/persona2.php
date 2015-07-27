<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Warehouse/Backstock Clerk</title>
		<link rel="stylesheet" type="text/css" href="../css/styles.css" />
		<link rel="stylesheet" type="text/css" href="../css/personas.css" />
	</head>
	<body>
		<div class="container">
			<header>
				<h1>
					Persona <strong>2</strong>
				</h1>
				<nav>
					<ul>
						<li><a href="../index.php">Home</a></li>
						<li><a href="./documentation.php">Epic</a></li>
						<li><a href="./persona1.php">Persona 1</a></li>
						<li><a href="./persona3.php">Persona 3</a></li>
						<li><a href="./wireframes.php">Wireframes</a></li>
					</ul>
				</nav>
			</header>
			<main>
				<h2>User Persona - Deanna, Small Business Owner</h2>


		<p><strong>User story:</strong> As a warehouse/backstock clerk, I play a key role in the supply chain of a small business&mdash;inventory is appropriately received, stored, handled, and removed from warehouse/backstock as needed to meet business needs.
		</p>My duties compose of four key work activities:
		<ol>
			<li>receiving inventory into warehouse</li>
			<li>storage of inventory within warehouse</li>
			<li>picking inventory from stock</li>
			<li>dispatching inventory from the warehouse</li>
			<li>returning inventory back to stock</li>
		</ol>

		<h2>User Cases</h2>

		<p>Use Case 1&mdash;Receiving products into warehouse:</p>
		<ul>
			<li><strong>input</strong> delivered/received products into data inventory application</li>
			<li>verify quality of delivered products </li>
			<ul>
				<li><strong>notify</strong> supply manager if quality is bad</li>
				<li><strong>remove</strong> damaged products from data inventory application</li>
				<li>return products to vender as instructed by supply manager</li>
			</ul>
			<li><strong>release</strong> approved stock products into data inventory application</li>
		</ul>



		<p>Use Case 2&mdash;Storage of inventory within warehouse</p>
		<ul>
			<li><strong>assign</strong> storage location for newly received stock into data inventory application</li>
			<uL>
				<li>place products into assigned storage location</li>
			</uL>
			<li>if relocating stock, <strong>assign</strong> new location into data inventory application</li>
			<ul>
				<li>relocate stock to new location in warehouse</li>
			</ul>
			<li>if stock is damaged, <strong>remove</strong> damaged products from data inventory application</li>
			<ul>
				<li><strong>notify</strong> supply manager if stock is damaged</li>
				<li>remove product from warehouse as instructed by supply manager</li>
			</ul>
		</ul>



		<p>Use Case 3&mdash;Picking inventory from stock:</p>
		<ul>
			<li>if picking products from stock, <strong>remove</strong> product count from data inventory application</li>
			<ul>
				<li><strong>notify</strong> supply manager if establishing minimum stock level is low</li>
			</ul>
			<li>take picked products to dispatched area</li>
		</ul>


		<p>Use Case 4&mdash;Dispatching inventory from the warehouse:</p>
		<ul>
			<li>picked products are taken to dispatched area for removal of product from warehouse as instructed</li>
			<ul>
				<li><strong>notify</strong> sales agent that items are leaving the warehouse and heading to their client</li>
				<li><strong>notify</strong> client that items are leaving the warehouse and heading their way</li>
			</ul>
		</ul>



		<p>Use Case 5&mdash;Returning products back to stock:</p>
		<ul>
			<li><strong>input</strong> returning products into data inventory application</li>
			<li><strong>assign</strong> storage location for returning products into data inventory application</li>
			<ul>
				<li>place products into assigned storage location</li>
				<li><strong>notify</strong> supply manager if establishing maximum stock level is high</li>
			</ul>
		</ul>








		<!--
				<div>
					<img class="diagram" src="images/warehouse_diagram.jpg" alt="warehouse-diagram" title="warehouse-diagram" />
					<p><small>Resource: http://log.logcluster.org/mobile/response/warehouse-management/index.html</small></p>
				</div>
		-->


		</main>
	</body>
</html>