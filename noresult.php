<!doctype html>

<html>
	<head>	
	<meta charset="utf-8">
	<link href="style.css" rel="stylesheet" type="text/css"/>
	<script src="javascript.js"></script>
	<title>Lego-Search</title>
	</head>
		<body>
		<div class="speechbubble">
		<h1>Oh no!</h1>
		<p>Unfortunately we could not find any matches for your search, try again!</p>
		</div>
		<div id="startpagetext">
		<table id="starttable">
			<tr>
				<td>
					<h1 class="headingstart">LEGOSEARCHER</h1>
				</td>
				<td>
					<img class="legoman_img" src="images/legoman_sad.png" alt="legoman_sad"/>
				</td>
			</tr>
		</table>	
		
				<div class="searchboxdiv" >
					<form name="searchform" action="search_database.php" method="GET" onsubmit="return validateForm()">
						<input class="searchbox" type="text" name="searchbox" placeholder="Search in the database..." >
						<input type="hidden" name="page" value="-1">
						<input  class="searchbutton" type="submit" value="Search">
					</form>
				</div>


	
		</div>
	</body>

</html>