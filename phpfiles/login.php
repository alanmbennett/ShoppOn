<?php
	session_start();
	include_once 'php_adds/header.html';
	include_once 'connect.php';
		$user = $_GET["email"];
		$pwd = $_GET["password"];
		$sql = "SELECT * FROM \"Users\"
			WHERE email = '$user'";
		$q = pg_query($conn, $sql);
		if (!$q){
			echo "error";
		}
		$row = pg_fetch_row($q);
		if ($row[0] == $user && $row[2] == $pwd){
			$_SESSION["email"] = $row[0];
			$_SESSION["password"] = $row[2];
			$_SESSION["name"] = $row[3];
			header("Location: ../index.html");
		}
		else{
			echo "login Fail";
		}
?>
