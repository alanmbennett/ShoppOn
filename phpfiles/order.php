<?php
  //outputs search results
  include 'connect.php';
  include 'php_adds/header.html';
  session_start();
  $email = $_SESSION["email"];
	$query = "SELECT o.\"order_no\", o.\"ordered_on\", o.\"est_arrival\", o.\"status\", s.\"ship_type\",
    u.\"ship_addr\"
    FROM \"Orders\" o, \"Ships_To\" s, \"Users\" u
    WHERE u.\"email\" = '$email' AND s.\"user_email\" = u.\"email\" AND s.\"order_no\" = o.\"order_no\"
    ;";
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

    while ($row = pg_fetch_row($qur)) {
      $total_cost = 0.00;
      echo "<h1>Order #$row[0]</h1>";
      echo "<b>Order Date:</b> $row[1]<br />";
      echo "<b>Estimated Delivery:</b> $row[2]<br />";
      echo "<b>Order Status:</b> $row[3]<br />";
      echo "<b>Shipping Type:</b> $row[4]<br />";
      echo "<b>Shipping To:</b> $row[5]<br />";

      $item_query = "SELECT pr.\"name\", b.\"quantity\", pr.\"image\", pr.\"cost\",
        pr.\"cost\"::money::numeric FROM \"Products\" pr, \"Belongs_To\" b
        WHERE b.\"order_no\" = '$row[0]' AND b.\"upc\" = pr.\"upc\";";

       $q2 = pg_query($connect, $item_query);

       echo "<table cellspacing=\"10\">\n";
       echo "<tr>";
       echo "<th><b>Image</b></th>";
       echo "<th><b>Item Name</b></th>";
       echo "<th><b>Quantity</b></th>";
       echo "<th><b>Price</b></th>";
       echo "</tr>";

       while ($items = pg_fetch_row($q2)) {
   	    echo "<tr>";
         echo "<td><img src=$items[2] /></td>";
     	  echo "<td>$items[0]</td>";
         echo "<td>$items[1]</td>";
         echo "<td>$items[3]</td>";
         $total_cost += $items[4]*$items[1];
     	  echo "</tr>";
       }

       echo "</table>";

       echo "<br /> <h1>Total: \$$total_cost</h1>";

       echo "<br /><br /><br />";
    }
?>
