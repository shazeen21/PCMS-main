<?php
	session_start();
	
	$USN1 = $_POST['USN'];
	$password = $_POST['PASSWORD'];
	$confirm = $_POST['repassword'];
	
	// Proper mysqli connection
	$connect = mysqli_connect("localhost", "root", "peter@272105"); // Establishing Connection with Server
	
	// Check connection
	if (!$connect) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	// Select database - fixed the mysqli_select_db syntax
	if (!mysqli_select_db($connect, "details")) {
		die("Can't Connect to database: " . mysqli_error($connect));
	}
	
	if($password == $confirm) {
		// Use prepared statement to prevent SQL injection
		$stmt = mysqli_prepare($connect, "UPDATE `details`.`hlogin` SET `Password` = ? WHERE `hlogin`.`Username` = ?");
		mysqli_stmt_bind_param($stmt, "ss", $password, $USN1);
		
		if(mysqli_stmt_execute($stmt)) {
			echo "<center>Password Reset Complete</center>";
			session_unset();
		} else {
			echo "Update Failed: " . mysqli_error($connect);
		}
		
		// Close the statement
		mysqli_stmt_close($stmt);
	} else {
		echo "Passwords do not match";
	}
	
	// Close the connection
	mysqli_close($connect);
?>