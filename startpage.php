<!doctype html>

<html>
	<head>	
	<meta charset="utf-8">
	<link href="style.css" rel="stylesheet" type="text/css"/>
	<script src="javascript.js"></script>
	<title>Lego-Search</title>
	</head>
		<body>

		<div class="startpagebg">
			<h1 class="headingstart">LEGOSEARCHER</h1>
		
				<div class="searchboxdiv">
					<form name="searchform" action="search_database.php" method="GET" onsubmit="return validateForm()">
						<input class="searchbox" type="text" name="searchbox" placeholder="Search in the database..." >
						<input  id="searchbutton" type="submit" value="Search">
					</form>
				</div>
			</div>
		</div>
		
		</body>
</html>
