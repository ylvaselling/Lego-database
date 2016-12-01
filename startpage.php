<?php include "menu.txt"; ?>

		<div class="middlediv">
			<h1 class="h1startpage">Search legopiece</h1>
		
			<form name="searchform" action="search_database.php" method="GET" onsubmit="return validateForm()">
				<input class="searchbox" type="text" name="searchbox" placeholder="Search in the database...">
				<input type="submit" value="Search">
			</form>
		</div>
		
		</body>
</html>
