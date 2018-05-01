<?php
  //outputs search results
  include 'connect.php';
  include 'php_adds/header.html';
  session_start();
  $email = $_SESSION["email"];
	$query = "SELECT pr.\"name\", ic.\"quantity\", pr.\"image\", pr.\"cost\", ic.\"upc\",
    pr.\"cost\"::money::numeric FROM \"Products\" pr, \"In_Cart\" ic
    WHERE ic.\"user_email\" = '$email' AND pr.\"upc\" = ic.\"upc\";";
  $total_cost = 0.00;
  $connect = $_GET["con"];
  if (!$connect){
    echo "Connect Fail!";
  }
	$qur = pg_query($connect, $query);
    if (!$qur){
      echo "<br />query failed! <br />";
    }
    $num_rows = pg_num_rows($qur);
    if($num_rows > 0)
    {
      echo "<h1>Contents of your Cart:</h1>";
      echo "<table cellspacing=\"10\">\n";
      echo "<tr>";
      echo "<th><b>Image</b></th>";
      echo "<th><b>Item Name</b></th>";
      echo "<th><b>Quantity</b></th>";
      echo "<th><b>Price</b></th>";
      echo "<th><b>Action</b></th>";
      echo "</tr>";
    }
    else {
      echo "<h1>Your cart is currently empty. Add stuff to it by searching!</h1>";
    }
    while ($row = pg_fetch_row($qur)) {
	    echo "<tr>";
      echo "<td><img src=$row[2] /></td>";
  	  echo "<td>$row[0]</td>";
      echo "<td>$row[1]</td>";
      echo "<td>$row[3]</td>";
      $total_cost += $row[5]*$row[1];
      echo "<td><form action=\"delete_cart.php\">
      <input type=\"text\" name=\"quantity\" class=\"quantity\"
        placeholder=\"quantity\" value=1 /><input type=\"hidden\" name=\"product\" value=\"$row[4]\"/>
        <input type=\"hidden\" name=\"prev_qty\" value=$row[1] />
        <input type=\"submit\" value=\"Delete\" /></form></td>";
  	  echo "</tr>";
    }
    echo "</table>";

    if($num_rows > 0)
    {
      echo "<br /> <h1>Estimated Total: \$$total_cost   </h1>";

      echo "<form action=\"place_order.php\">
        <input type=\"hidden\" name=\"email\" value=\"$email\"/>
        <input type=\"submit\" value=\"Order\" /></form>";
    }
?>
