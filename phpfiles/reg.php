<?php
	session_start();
	include_once 'connect.php';
	include_once 'php_adds/header.html';
	$name = $_GET["name"];
	$email = $_GET["email"];
	$password = $_GET["password"];
	$confpassword = $_GET["confirmpassword"];
	$address = $_GET["addr"];
	if ($password == $confpassword){
		//check if user with entered email already exists
		$q_user_exist = "SELECT \"email\"
						FROM \"Users\"
						WHERE \"email\"= \"$email\"";
	$connect = $_GET["con"];
	$q = pg_query($connect, $q_user_exist);
	$row = pg_fetch_row($q);
	if ($row[0] != $email){
		$insert = "INSERT INTO \"Users\"
		VALUES ('$email','$address','$password','$name')";
		$q2 = pg_query($connect, $insert);
		if (!$q2){
			echo "User with that email login already taken.<br />";
			echo "<a href=\"../index.html\">Return to Home</a> | ";
			echo "<a href=\"../createaccount.html\">Return to Account Creation page</a>";
		}
		else {
			$_SESSION["email"] = $email;
			$_SESSION["password"] = $password;
			$_SESSION["name"] = $name;
			header('Location: ../index.html');
		}
	}
	else{
		echo "User with that email login already taken.<br />";
		echo "<a href=\"../createaccount.html\">Return to Account Creation page</a>";
	}
	}
	else{
		echo "Passwords don't match!";
	}
?>
