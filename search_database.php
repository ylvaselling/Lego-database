<?php 

$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");

if (!$connection) 
			{
				die('MySQL connection error');
			}

$keyword = $_GET['searchbox'];

/*if($keyword === null)
{
	header ("location: http://www.google.se");
	exit();
}*/

$result = mysqli_query($connection, "SELECT inventory.SetID, sets.Setname, sets.Year, colors.Colorname, images.has_gif FROM inventory, sets, parts, colors, images
									WHERE parts.PartID=inventory.ItemID AND inventory.SetID=sets.SetID AND inventory.Extra='N'
									AND inventory.ColorID=colors.ColorID AND inventory.ItemID=images.ItemID AND (Partname LIKE '%$keyword%' OR PartID='$keyword')");

		print("<table>\n<tr>");
		while($fieldinfo = mysqli_fetch_field($result))
		{
			print("<th>". $fieldinfo->name . "</th>");
		}
		
		print("</tr>\n");
		while($row = mysqli_fetch_row($result))
		{
			print("<tr>");
			
			for($i=0; $i<mysqli_num_fields($result); $i++)
			{
				print("<td>$row[$i]</td>");				
			}
			$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
			$ItemID = $row['ItemID'];
			$ColorID = $row['ColorID'];
			  // Query the database to see which files, if any, are available
			  $imagesearch = mysqli_query($conn, "SELECT * FROM images WHERE ItemTypeID='S' AND ItemID='$ItemID' AND ColorID=$ColorID");
			  // By design, the query above should return exactly one row.
			  $imageinfo = mysqli_fetch_array($imagesearch);
			  if($imageinfo['has_jpg']) { // Use JPG if it exists
				$filename = "S/$ColorID/$ItemID.jpg";
			   } else if($imageinfo['has_gif']) { // Use GIF if JPG is unavailable
				 $filename = "S/$ColorID/$ItemID.gif";
			   } else { // If neither format is available, insert a placeholder image
				 $filename = "noimage_small.png";
			   }
			print("<td>$filename</td>");
			print("<td><img src=\"$prefix$filename\" alt=\"Part $ItemID\"/></td>");
			print("</tr>\n");
		}
		mysqli_close($connection);



?>