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

$result = mysqli_query($connection, "SELECT parts.Partname, parts.PartID, inventory.SetID, sets.Year, sets.Setname FROM
					inventory, sets, parts WHERE sets.SetID=inventory.SetID AND ItemTypeID='P' AND
				 Partname LIKE '%$keyword%' ORDER BY sets.Year DESC");

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
			print("</tr>\n");
		}
		mysqli_close($connection);



?>
