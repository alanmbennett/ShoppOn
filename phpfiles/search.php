<?php
  //outputs search results
  include 'connect.php';
  include 'php_adds/header.html';
  session_start();
  $product = $_GET["search"];
	$query = "SELECT \"name\", \"cost\", \"image\", \"upc\"
            FROM \"Products\"
            WHERE \"name\" LIKE '%$product%' LIMIT 100";
  $connect = $_GET["con"];
  if (!$connect){
    echo "Connect Fail!";
  }
	$qur = pg_query($connect, $query);
    if (!$qur){
      echo "<br />query failed! <br />";
    }
  $num_rows = pg_num_rows($qur);
    echo "<h1>Retrieved $num_rows results matching your search:</h1>";
    echo "<table cellspacing=\"10\">\n";
    echo "<tr>";
    echo "<th><b>Image</b></th>";
    echo "<th><b>Item Name</b></th>";
    echo "<th><b>Price</b></th>";
    echo "<th>Order</th>";
    echo "</tr>";
    while ($row = pg_fetch_row($qur)) {
	    echo "<tr>";
      echo "<td><img src=$row[2] /></td>";
  	  echo "<td>$row[0]</td>";
      echo "<td>$row[1]</td>";
      if(null != $_SESSION["email"]) {
      echo "<td><form action=\"add_to_cart.php\"><input type=\"text\" name=\"quantity\" class=\"quantity\"
        placeholder=\"quantity\" value=1 /><input type=\"hidden\" name=\"product\" value=\"$row[3]\"/>
        <input type=\"submit\" name = \"add_cart\" value=\"Add to Cart\" />
      </form></td>";
      }
      else
      {
        echo "<td>Please log in to order this item.</td>";
      }
  	  echo "</tr>";
    }
    echo "</table>";
?>
