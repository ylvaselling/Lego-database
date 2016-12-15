<?php 	include "menu.txt";
	


	$found = $_GET['foundpart'];
	
	echo "<div class='header'>
		<h1>These sets are what we found!</h1>
		</div>";
		
	echo "<div class='middlediv'>"; 
	
	
	$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
	if (!$connection) 
			{
				die('MySQL connection error');
			}

	
		/*Pagenation*/
		$recordsperpage = 20;

		$sql = "SELECT count(sets.SetID) FROM sets";

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
	
		$result = mysqli_query($connection, "SELECT DISTINCT inventory.SetID, sets.Setname, sets.Year, categories.Categoryname 
													FROM inventory, sets, parts, categories
													WHERE sets.CatID=categories.CatID 
													AND parts.PartID=inventory.ItemID 
													AND inventory.SetID=sets.SetID 
													AND inventory.Extra='N'
													AND (Partname LIKE '$found'
													OR PartID='$found')");	
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

		if(! $returnvalue)
		{
			die('Could not get data: ' . mysqli_error());
		}

	
		/*Query and Print*/		
		$resultinpages = mysqli_query($connection, "SELECT DISTINCT inventory.SetID, sets.Setname, sets.Year, categories.Categoryname 
													FROM inventory, sets, parts, categories
													WHERE sets.CatID=categories.CatID 
													AND parts.PartID=inventory.ItemID 
													AND inventory.SetID=sets.SetID 
													AND inventory.Extra='N'
													AND (Partname LIKE '$found'
													OR PartID='$found')
													LIMIT $offset, $recordsperpage");
						
						
		

		print("<table class='displaytableset'>\n<tr>");

		while($fieldinfo = mysqli_fetch_field($resultinpages))
		{
			print("<th>". $fieldinfo->name . "</th>");
		}
		
		print ("<th>Images</th>");
		
		print("</tr>\n");
		
		while($row = mysqli_fetch_array($resultinpages))
		{
			print("<tr>");
			for($i=0; $i<mysqli_num_fields($resultinpages); $i++)
			{
				print("<td>$row[$i]</td>");	
			}
			
				// Determine the file name for the small 80x60 pixels image, with a preference for JPG format.
			   $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
			   $SetID = $row['SetID'];
			   
			   // Query the database to see which files, if any, are available
			   $imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='S' AND 
			   ItemID='$SetID' ");
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
			   print("<td><a href='$prefix$large_filename' </a> <img id='$SetID' class='small_img' src=\"$prefix$filename\" alt=\"$Setname\"  /></td>");
			   print("</tr>\n");

		}
				
		echo "</table>";
		echo "</div>";
		
		/*Page buttons*/
		echo "<div class='pagefooter'>";
		
				
			if ($page == 0 && $page == ($maxpage-1))
			{
				echo "<img class='pagebutton' src='images/empty.png' alt='previous'>";
				
				echo "<img  class='pagebutton' src='images/empty.png' alt='next'>";
			}
			else if($page > 0 && $page < ($maxpage-1))
			{
				$last = $page - 2;
				
				echo "<a href = \"$_PHP_SELF?foundpart=$found&page=$last\">
				<img class='pagebutton' src='images/prev.png' alt='previous'></a>";
				
				echo "<a href = \"$_PHP_SELF?foundpart=$found&page=$page\">
				<img  class='pagebutton' src='images/next.png' alt='next'>
				</a>";
			}
			else if ($page == 0)
			{
				echo "<img class='pagebutton' src='images/empty.png' alt='previous'>";
				
				echo "<a href = \"$_PHPSELF?foundpart=$found&page=$page\">
				<img  class='pagebutton' src='images/next.png' alt='next'></a>";
			}
			else if ($page == ($maxpage-1))
			{
				$last = $page - 2;
				echo "<a href = \"$_PHPSELF?foundpart=$found&page=$last\">
				<img class='pagebutton' src='images/prev.png' alt='previous'></a>";
				
				echo "<img  class='pagebutton' src='images/empty.png' alt='next'>";
			}
		echo "</div>";

		
		mysqli_close($connection);
		
		
?>


	</body>
	</html>
	
