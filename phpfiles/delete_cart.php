<?php
  //outputs search results
  include 'connect.php';
  include 'php_adds/header.html';
  session_start();
  $email = $_SESSION["email"];
  $product = $_GET["product"];
  $quantity = $_GET["quantity"];
  $prev_qty = $_GET["prev_qty"];
  $new_qty = $prev_qty - $quantity;
	$update_query = "UPDATE \"In_Cart\" SET \"quantity\" = $new_qty
  WHERE \"upc\" = '$product';";
  $delete_query= "DELETE FROM \"In_Cart\" WHERE \"upc\" = '$product' AND \"user_email\" = '$email';";
  $connect = $_GET["con"];
  if (!$connect){
    echo "Connect Fail!";
  }

  if($new_qty == 0)
  {
    $qur = pg_query($connect, $delete_query);
      if (!$qur){
        echo "<br />query failed! <br />";
      }
      else {
        header('Location: cart.php');
      }
  }

  else if($new_qty < 0)
  {
    header('Location: cart.php');
  }

  else {
    $qur = pg_query($connect, $update_query);
      if (!$qur){
        echo "<br />query failed! <br />";
      }
      else {
        header('Location: cart.php');
      }
  }
?>
