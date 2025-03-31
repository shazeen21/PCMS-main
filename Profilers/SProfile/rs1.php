<?php
	session_start();
	
	// Check if form is submitted
	if(isset($_POST['USN']) && isset($_POST['PASSWORD']) && isset($_POST['repassword'])) {
		$USN1 = $_POST['USN'];
		$password = $_POST['PASSWORD'];
		$confirm = $_POST['repassword'];
		
		// Check if reset session exists
		if(isset($_SESSION['reset'])) {
			$USN2 = $_SESSION['reset'];
			
			// Establishing Connection with Server using MySQLi
			$connect = mysqli_connect("localhost", "root", "peter@272105", "details");
			
			// Check connection
			if(!$connect) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
			// Check if all fields are filled
			if($USN1 && $password && $confirm) {
				// Check if passwords match
				if($password == $confirm) {
					// Check if USN matches the one in session
					if($USN2 == $USN1) {
						// Using prepared statement for update
						$update_stmt = mysqli_prepare($connect, "UPDATE slogin SET PASSWORD = ? WHERE USN = ?");
						mysqli_stmt_bind_param($update_stmt, "ss", $password, $USN1);
						
						if(mysqli_stmt_execute($update_stmt)) {
							echo "<center>Password Reset Complete</center>";
							session_unset();
						} else {
							echo "<center>Update Failed: " . mysqli_error($connect) . "</center>";
							session_unset();
						}
						
						mysqli_stmt_close($update_stmt);
					} else {
						echo "<center>Enter Your USN only</center>";
						session_unset();
					}
				} else {
					echo "<center>Passwords do not match</center>";
					session_unset();
				}
			} else {
				echo "<center>Field cannot be left blank</center>";
				session_unset();
			}
			
			// Close connection
			mysqli_close($connect);
		} else {
			echo "<center>Reset session not found. Please start the reset process again.</center>";
		}
	} else {
		echo "<center>Please submit the form with all required fields</center>";
	}
?>