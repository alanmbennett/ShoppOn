<?php
  //outputs search results
  include 'connect.php';
  include 'php_adds/header.html';
  session_start();

  $connect = $_GET["con"];
  if (!$connect){
    echo "Connect Fail!";
  }

  $email = $_GET["email"];

  $order_no = rand(9870000000, 9879999999);

  $order_no_query = "SELECT \"order_no\" FROM \"Orders\" WHERE \"order_no\" = '$order_no';";
  $q = pg_query($connect, $order_no_query);

  if (!$q){
    echo "<br />order no query failed! <br />";
  }

  $check_no = pg_fetch_row($q);

  while($check_no == $order_no)
  {
    $order_no = rand(9870000000, 9879999999);

    $order_no_query = "SELECT \"order_no\" FROM \"Orders\" WHERE \"order_no\" = '$order_no';";
    $q = pg_query($connect, $order_no_query);
    $check_no = pg_fetch_row($q);
  }

  $arr_random = rand(2, 31);
  $today = date("Y-m-d");
  $arrival = date("Y-m-d", strtotime("+$arr_random days"));

  $order_query = "INSERT INTO \"Orders\" VALUES ('$order_no', '$today', '$arrival', 'Processing');";
  $q = pg_query($connect, $order_query);
  $ships_query = "INSERT INTO \"Ships_To\" VALUES ('$order_no', '$email', 'UPS Ground');";
  $q = pg_query($connect, $ships_query);
  $cart_query = "SELECT \"upc\", \"quantity\" FROM \"In_Cart\" WHERE \"user_email\" = '$email';";
  $qur = pg_query($connect, $cart_query);

  while ($row = pg_fetch_row($qur))
  {
    $add_query = "INSERT INTO \"Belongs_To\" VALUES ('$row[0]', '$order_no', $row[1]);";
    $q = pg_query($connect, $add_query);
    $delete_query= "DELETE FROM \"In_Cart\" WHERE \"upc\" = '$row[0]' AND \"user_email\" = '$email';";
    $q = pg_query($connect, $delete_query);
  }

  header('Location: order.php');
?>
