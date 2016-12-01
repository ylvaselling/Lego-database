<?php 

$connection = mysqli_connect("mysql.itn.liu.se","lego","", "lego");

if (!$connection) 
			{
				die('MySQL connection error');
			}

$keyword = $_GET['searchbox'];

$bricks = mysqli_query($connection, "SELECT parts.PartID, parts.Partname FROM parts WHERE (Partname LIKE '%$keyword%' OR PartID='$keyword')");



if(mysqli_num_rows($bricks)==0)
{
    print("No results");
}

else if(mysqli_num_rows($bricks)==1)
{

	$result = mysqli_query($connection, "SELECT inventory.SetID, sets.Setname, sets.Year FROM inventory, sets, parts
									WHERE parts.PartID=inventory.ItemID AND inventory.SetID=sets.SetID AND inventory.Extra='N'
									AND (Partname LIKE '%$keyword%' OR PartID='$keyword')");

		print("<table>\n<tr>");
		while($fieldinfo = mysqli_fetch_field($result))
		{
			
			$found=1;
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
}

else
{
				print("<table>\n<tr>");
		while($fieldinfo = mysqli_fetch_field($bricks))
		{
			$found=1;
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
			print("</tr>\n");
		}

}
		mysqli_close($connection);
?>
