<?php include "menu.txt"; ?>

		<div class="middlediv">
			<h1 class="headingstart">Search Legopiece</h1>
		
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
