<?php 

$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");

if (!$connection) 
			{
				die('MySQL connection error');
			}

$keyword = $_GET['searchbox'];

$bricks = mysqli_query($connection, "SELECT inventory.ItemID, 
inventory.ColorID, colors.Colorname, parts.Partname 
FROM inventory, parts, colors WHERE inventory.Extra='N' AND inventory.ItemTypeID='P' 
AND inventory.ItemID=parts.PartID AND inventory.ColorID=colors.ColorID AND (Partname LIKE '%$keyword%' OR PartID='$keyword') LIMIT 50");

if(mysqli_num_rows($bricks)==0)
{
    print("No results");
}

else if(mysqli_num_rows($bricks)==1)
{

	$result = mysqli_query($connection, "SELECT inventory.SetID, sets.Setname, sets.Year, colors.Colorname FROM
										inventory, sets, parts, colors
										WHERE parts.PartID=inventory.ItemID AND inventory.SetID=sets.SetID 
										AND inventory.Extra='N'
										AND inventory.ColorID=colors.ColorID AND (Partname LIKE '%$keyword%'
										OR PartID='$keyword')");

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
				/*// Determine the file name for the small 80x60 pixels image, with a preference for JPG format.
			   $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
			   $ItemID = $row['ItemID'];
			   // Query the database to see which files, if any, are available
			   $imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='S' AND 
			   ItemID='$ItemID'");
			   // By design, the query above should return exactly one row.
			   $imageinfo = mysqli_fetch_array($imagesearch);
			   if($imageinfo['has_jpg']) { // Use JPG if it exists
				 $filename = "S/$ItemID.jpg";
			   } else if($imageinfo['has_gif']) { // Use GIF if JPG is unavailable
				 $filename = "S/$ItemID.gif";
			   } else { // If neither format is available, insert a placeholder image
				 $filename = "noimage_small.png";
			   }
			   print("<td>$filename</td>");
			   print("<td><img src=\"$prefix$filename\" alt=\"Part $ItemID\"/></td>");
			   print("</tr>\n");*/
		}
}

else
{
		print("<table>\n<tr>");
		while($fieldinfo = mysqli_fetch_field($bricks))
		{
			
			print("<th>". $fieldinfo->name . "</th>");
		}
		
		print("</tr>\n");
		while($row = mysqli_fetch_row($bricks))
		{
			print("<tr>");
			for($i=0; $i<mysqli_num_fields($bricks); $i++)
			{
				print("<td>$row[$i]</td>");
				
			}
			
		// Determine the file name for the small 80x60 pixels image, with a preference for JPG format.
		   $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
		   $ItemID = $row['ItemID'];
		   $ColorID = $row['ColorID'];
		   // Query the database to see which files, if any, are available
		   $imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='P' AND ItemID='$ItemID' 
		   AND ColorID=$ColorID");
		   // By design, the query above should return exactly one row.
		   $imageinfo = mysqli_fetch_array($imagesearch);
		   if($imageinfo['has_jpg']) { // Use JPG if it exists
			 $filename = "P/$ColorID/$ItemID.jpg";
		   } else if($imageinfo['has_gif']) { // Use GIF if JPG is unavailable
			 $filename = "P/$ColorID/$ItemID.gif";
		   } else { // If neither format is available, insert a placeholder image
			 $filename = "noimage_small.png";
		   }
		   print("<td>$filename</td>");
		   print("<td><img src=\"$prefix$filename\" alt=\"Part $ItemID\"/></td>");
		   print("<td>$ItemID</td>");
		   print("<td>$ColorID</td>");
		   /*$Colorname = $row['Colorname'];
		   $Partname = $row['Partname'];
		   print("<td>$Colorname</td>");
		   print("<td>$Partname</td>");*/
		   print("</tr>\n");
			
		}

}
		mysqli_close($connection);
?>
