<?php 	include "menu.txt";

	echo "<div class='middlediv'>"; 
	
	$found = $_GET['foundpart'];
	
	$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");

	if (!$connection) 
			{
				die('MySQL connection error');
			}


	$result = mysqli_query($connection, "SELECT inventory.SetID, sets.Setname, sets.Year FROM
										inventory, sets, parts
										WHERE parts.PartID=inventory.ItemID AND inventory.SetID=sets.SetID 
										AND inventory.Extra='N'
										AND (Partname LIKE '$found'
										OR PartID='$found')");

		print("<table>\n<tr>");
		while($fieldinfo = mysqli_fetch_field($result))
		{
			
			
			print("<th>". $fieldinfo->name . "</th>");
		}
		
		print ("<th>Images</th>");
		
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



		mysqli_close($connection);
		
		
?>

	</div>
	</body>
	</html>
	

