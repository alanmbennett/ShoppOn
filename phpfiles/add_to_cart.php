<?php
  //outputs search results
  include 'connect.php';
  include 'php_adds/header.html';
  session_start();
  $email = $_SESSION["email"];
  $product = $_GET["product"];
  $quantity = $_GET["quantity"];
  $check = "SELECT \"upc\", \"quantity\" FROM \"In_Cart\" WHERE \"upc\" = '$product';";
	$query = "INSERT INTO \"In_Cart\" VALUES ('$product', '$email', $quantity);";
  $connect = $_GET["con"];
  if (!$connect){
    echo "Connect Fail!";
  }

  $q = pg_query($connect, $check);
	$row = pg_fetch_row($q);
	if ($row[0] != $product)
  {
	   $qur = pg_query($connect, $query);
     if (!$qur){
       echo "<br />query failed! <br />";
     }
     else {
       header('Location: cart.php');
     }
  }

  else {
    $new_qty = $row[1] + $quantity;
    $update_query = "UPDATE \"In_Cart\" SET \"quantity\" = $new_qty
    WHERE \"upc\" = '$product';";

    $qur = pg_query($connect, $update_query);
    if (!$qur){
      echo "<br />query failed! <br />";
    }
    else {
      header('Location: cart.php');
    }
  }
?>
