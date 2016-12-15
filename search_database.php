<?php 	include "menu.txt";
		
echo "<div class='middlediv'>"; 

$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
if (!$connection) 
			{
				die('MySQL connection error');
			}
			

	$keyword = $_GET['searchbox'];



$bricks = mysqli_query($connection, "SELECT DISTINCT inventory.ItemID, inventory.ColorID, colors.Colorname, parts.Partname 
FROM inventory, parts, colors WHERE inventory.Extra='N' AND inventory.ItemTypeID='P' 
AND inventory.ItemID=parts.PartID AND inventory.ColorID=colors.ColorID 
AND (Partname LIKE '%$keyword%' OR PartID='$keyword') ORDER BY parts.Partname ASC");



/*Code that actually works*/
if(mysqli_num_rows($bricks)==0)
{
	header("Location: noresult.php");
}

else if(mysqli_num_rows($bricks)==1)
{
/*

	$result = mysqli_query($connection, "SELECT DISTINCT inventory.SetID, sets.Setname, sets.Year FROM
										inventory, sets, parts
										WHERE parts.PartID=inventory.ItemID AND inventory.SetID=sets.SetID 
										AND inventory.Extra='N'
										AND (Partname LIKE '%$keyword%'
										OR PartID='$keyword')");
		print("<table class='displaytableset'>\n<tr>");

		echo "<div class='header'><h1>These are your sets!</h1></div>";
		/*Pagenation

		$recordsperpage = 20;

		$sql = "SELECT count(sets.ID) FROM sets";

		$returnvalue = mysqli_query($connection, $sql);


		if(isset($_GET['page']))
		{
			$page = $_GET['page']+1;
			$offset = $recordsperpage * $page;
		}
		else
		{
			$page = 0;
			$offset = 0;
		}
		$result = mysqli_query($connection, "SELECT DISTINCT inventory.SetID, sets.Setname, sets.Year FROM
											inventory, sets, parts WHERE parts.PartID=inventory.ItemID AND 
											inventory.SetID=sets.SetID AND inventory.Extra='N'
											AND (Partname LIKE '%$keyword%'
											OR PartID='$keyword')");

		$pagerow = mysqli_num_rows($result);

		$left_rec = $pagerow - ($page * $recordsperpage);
		
		$maxpage=0;
		
		if($pagerow%$recordsperpage==0)
		{
			$maxpage = $pagerow/$recordsperpage;
		}
		else if($pagerow%$recordsperpage!=0)
		{
			$maxpage = (($pagerow-($pagerow%$recordsperpage))/$recordsperpage)+1;
		}

		$returnvalue = mysqli_query($connection, $sql);


		Query and Print
		$result = mysqli_query($connection, "SELECT DISTINCT inventory.SetID, sets.Setname, sets.Year FROM
											inventory, sets, parts WHERE parts.PartID=inventory.ItemID AND 
											inventory.SetID=sets.SetID AND inventory.Extra='N'
											AND (Partname LIKE '%$keyword%'
											OR PartID='$keyword') LIMIT $offset, $recordsperpage");
		
		
		/*Print results
		print("<table class='displaytable'>\n<tr>");

		while($fieldinfo = mysqli_fetch_field($result))
		{
			
			
			print("<th>". $fieldinfo->name . "</th>");
		}
		
		print("</tr>\n");
		while($row = mysqli_fetch_array($result))
		{
			print("<tr>");
			for($i=0; $i<mysqli_num_fields($result); $i++)
			{
				print("<td>$row[$i]</td>");
				
			}
				// Determine the file name for the small 80x60 pixels image, with a preference for JPG format.
			   $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
			   $SetID = $row['SetID'];
			   
			   // Query the database to see which files, if any, are available
			   $imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='S' AND 
			   ItemID='$SetID'");
			   // By design, the query above should return exactly one row.
			   $imageinfo = mysqli_fetch_array($imagesearch);
			   
			   if($imageinfo['has_largejpg']) // Use JPG if it exists
			   { 
					$large_filename = "SL/$SetID.jpg";
					
			   } 
			   else if($imageinfo['has_largegif']) // Use GIF if JPG is unavailable
			   { 
				
					$large_filename = "SL/$SetID.gif";
					
			   }
			   else // If neither format is available, insert a placeholder image
			   { 
					$large_filename = "noimage_large.png";
					
			   }
	
			   if($imageinfo['has_jpg']) // Use JPG if it exists
			   { 
					$filename = "S/$SetID.jpg";
			   } 
			   else if($imageinfo['has_gif']) // Use GIF if JPG is unavailable
			   { 
					$filename = "S/$SetID.gif";
			   } 
			   else // If neither format is available, insert a placeholder image
			   { 
					$filename = "noimage_small.png";
			   }
			   print("<td><a href='$prefix$large_filename' </a><img src=\"$prefix$filename\" alt=\"Part $SetID\"/></td>");
			   print("</tr>\n");
		}
		echo "</table>";
		echo "</div>";
		echo "<div class='pagefooter'>";
		
				
			if ($page == 0 && $page == ($maxpage-1))
			{
				echo "<img class='pagebutton' src='images/prev.png' alt='previous'>";
				echo "<img  class='pagebutton' src='images/next.png' alt='next'>";
			}
			else if($page > 0 && $page < ($maxpage-1))
			{
				$last = $page - 2;
				echo "<a href = \"$_PHP_SELF?searchbox=$keyword&page=$last\">
				<img class='pagebutton' src='images/prev.png' alt='previous'></a>";
				echo "<a href = \"$_PHP_SELF?searchbox=$keyword&page=$page\">
				<img  class='pagebutton' src='images/next.png' alt='next'>
				</a>";
			}
			else if ($page == 0)
			{
				echo "<img class='pagebutton' src='images/prev.png' alt='previous'>";
				echo "<a href = \"$_PHPSELF?searchbox=$keyword&page=$page\">
				<img  class='pagebutton' src='images/next.png' alt='next'></a>";
			}
			else if ($page == ($maxpage-1))
			{
				$last = $page - 2;
				echo "<a href = \"$_PHPSELF?searchbox=$keyword&page=$last\">
				<img class='pagebutton' src='images/prev.png' alt='previous'></a>";
				echo "<img  class='pagebutton' src='images/next.png' alt='next'>";
			}
		echo "</div>";*/

		$found = $keyword;
		
		header("Location: brick_found.php?foundpart=$found");

			
}

else
{
		/*Pagenation RÖR EJ, NICHT RÖREN, NO TOUCHIE*/
		$recordsperpage = 20;

		$sql = "SELECT count(inventory.ItemID) FROM inventory";

		$returnvalue = mysqli_query($connection, $sql);

		if(! $returnvalue)
		{
			die('Could not get data: ' . mysqli_error());
		}

		if(isset($_GET['page']))
		{
			$page = $_GET['page']+1;
			$offset = $recordsperpage * $page;
		}
		else
		{
			$page = 0;
			$offset = 0;
		}
		
		
		$pagerow = mysqli_num_rows($bricks);

		

		$left_rec = $pagerow - ($page * $recordsperpage);
		
		$maxpage=0;
		
		if($pagerow%$recordsperpage==0)
		{
			$maxpage = $pagerow/$recordsperpage;
		}
		else if($pagerow%$recordsperpage!=0)
		{
			$maxpage = (($pagerow-($pagerow%$recordsperpage))/$recordsperpage)+1;
		}
			


		$returnvalue = mysqli_query($connection, $sql);

		if(! $returnvalue)
		{
			die('Could not get data: ' . mysqli_error());
		}
			
			
		
		
			
			$bricks = mysqli_query($connection, "SELECT DISTINCT inventory.ItemID, inventory.ColorID, colors.Colorname, parts.Partname 
			FROM inventory, parts, colors WHERE inventory.Extra='N' AND inventory.ItemTypeID='P' 
			AND inventory.ItemID=parts.PartID AND inventory.ColorID=colors.ColorID 
			AND (Partname LIKE '%$keyword%' OR PartID='$keyword') ORDER BY parts.Partname ASC 
			LIMIT $offset, $recordsperpage");
	
	print("<table class='displaytable'>\n<tr>");
		
		while($fieldinfo = mysqli_fetch_field($bricks))
		{
			print("<th>". $fieldinfo->name . "</th>");
		}
	
	print("</tr>\n");
		
		while($row = mysqli_fetch_array($bricks))
		{
			// Determine the file name for the small 80x60 pixels image, with a preference for JPG format.
			$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
			$ItemID = $row['ItemID'];
			$ColorID = $row['ColorID'];
			// Query the database to see which files, if any, are available
			$imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='P' AND ItemID='$ItemID' AND ColorID='$ColorID'");
			// By design, the query above should return exactly one row.
			$imageinfo = mysqli_fetch_array($imagesearch);
			
			print ("<form method='GET' action='brick_found.php'>");
			
			print("<tr>");
			
			for($i=0; $i<mysqli_num_fields($bricks); $i++)
			{
				print("<td>$row[$i]</td>");
			}
			
			if($imageinfo['has_jpg']) 
			{ 
				$filename = "P/$ColorID/$ItemID.jpg"; // Use JPG if it exists
			}
			else if($imageinfo['has_gif']) 
			{ 
				$filename = "P/$ColorID/$ItemID.gif"; // Use GIF if JPG is unavailable
			} 
			else 
			{ 
				$filename = "noimage_small.png"; // If neither format is available, insert a placeholder image
			}
			print("<td><img src=\"$prefix$filename\" alt=\"Part $ItemID\"/></td>");
			
			print("<td class='last_col'><input id='choosebrick' type='image' src='images/choose_lego.png' name='foundpart' value='$ItemID'></td>");

			print("</tr>\n");	
		}
		
		
		echo "</table>";
		echo "</div>";
		echo "<div class='pagefooter'>";
		
				
			if ($page == 0 && $page == ($maxpage-1))
			{
				echo "<img class='pagebutton' src='images/prev.png' alt='previous'>";
				echo "<img  class='pagebutton' src='images/next.png' alt='next'>";
			}
			else if($page > 0 && $page < ($maxpage-1))
			{
				$last = $page - 2;
				echo "<a href = \"$_PHP_SELF?searchbox=$keyword&page=$last\">
				<img class='pagebutton' src='images/prev.png' alt='previous'></a>";
				echo "<a href = \"$_PHP_SELF?searchbox=$keyword&page=$page\">
				<img  class='pagebutton' src='images/next.png' alt='next'>
				</a>";
			}
			else if ($page == 0)
			{
				echo "<img class='pagebutton' src='images/prev.png' alt='previous'>";
				echo "<a href = \"$_PHPSELF?searchbox=$keyword&page=$page\">
				<img  class='pagebutton' src='images/next.png' alt='next'></a>";
			}
			else if ($page == ($maxpage-1))
			{
				$last = $page - 2;
				echo "<a href = \"$_PHPSELF?searchbox=$keyword&page=$last\">
				<img class='pagebutton' src='images/prev.png' alt='previous'></a>";
				echo "<img  class='pagebutton' src='images/next.png' alt='next'>";
			}
		echo "</div>";

}

		mysqli_close($connection);
		
		
?>


	</body>
	</html>
	
