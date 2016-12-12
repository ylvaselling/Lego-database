<?php 	include "menu.txt";
		
echo "<div class='middlediv'>"; 

$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");
if (!$connection) 
			{
				die('MySQL connection error');
			}
			
$keyword = $_GET['searchbox'];

$bricks = mysqli_query($connection, "SELECT inventory.ItemID, inventory.ColorID, colors.Colorname, parts.Partname 
FROM inventory, parts, colors WHERE inventory.Extra='N' AND inventory.ItemTypeID='P' 
AND inventory.ItemID=parts.PartID AND inventory.ColorID=colors.ColorID 
AND (Partname LIKE '%$keyword%' OR PartID='$keyword') ORDER BY ItemID, ColorID DESC" );


if(mysqli_num_rows($bricks)==0)
{
    print("No results");
}

else if(mysqli_num_rows($bricks)==1)
{
	$result = mysqli_query($connection, "SELECT inventory.SetID, sets.Setname, sets.Year FROM
										inventory, sets, parts
										WHERE parts.PartID=inventory.ItemID AND inventory.SetID=sets.SetID 
										AND inventory.Extra='N'
										AND (Partname LIKE '%$keyword%'
										OR PartID='$keyword')");
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
			   print("<td><img src=\"$prefix$filename\" alt=\"Part $SetID\"/></td>");
			   print("</tr>\n");
		}
}

else
{
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
			
			print("<td><input class='searchbutton' type='submit' name='foundpart' value='$ItemID'></td>");

			print("</tr>\n");	
		}
}

		mysqli_close($connection);
		
		
?>

	</div>
	</body>
	</html>
	
