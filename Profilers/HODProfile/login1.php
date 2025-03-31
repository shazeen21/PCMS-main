<?php
	session_start();
	
	// Check if form fields are set using isset() to avoid warnings
	$branch = isset($_POST['Branch']) ? $_POST['Branch'] : '';
	$husername = isset($_POST['username']) ? $_POST['username'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	
	if ($husername && $password && $branch)
	{
		// Using mysqli instead of mysql
		$connect = mysqli_connect("localhost", "root", "Peter@272105", "details") or die("Couldn't Connect: " . mysqli_connect_error());
		
		// Use prepared statements to prevent SQL injection
		$query = mysqli_prepare($connect, "SELECT * FROM hlogin WHERE Username = ?");
		mysqli_stmt_bind_param($query, "s", $husername);
		mysqli_stmt_execute($query);
		$result = mysqli_stmt_get_result($query);
		
		$numrows = mysqli_num_rows($result);
		
		if ($numrows != 0)
		{
			$row = mysqli_fetch_assoc($result);
			$dbbranch = $row['Branch'];
			$dbusername = $row['Username'];
			$dbpassword = $row['Password'];
			
			if ($branch == $dbbranch && $husername == $dbusername && $password == $dbpassword)
			{
				echo "<center>Login Successful..!! <br/>Redirecting you to HomePage! </br>If not Goto <a href='index.php'> Here </a></center>";
				echo "<meta http-equiv='refresh' content ='3; url=index.php'>";
				$_SESSION['husername'] = $husername;
				$_SESSION['department'] = $branch;
			} 
			else {
				$message = "Username and/or Password and/or Department are/is incorrect.";
				echo "<script type='text/javascript'>alert('$message');</script>";
				echo "<center>Redirecting you back to Login Page! If not Goto <a href='index.php'> Here </a></center>";
				echo "<meta http-equiv='refresh' content ='1; url=index.php'>";
			}
		} 
		else {
			$message = "User does not exist";
			echo "<script type='text/javascript'>alert('$message');</script>";
			echo "<center>Redirecting you back to Login Page! If not Goto <a href='index.php'> Here </a></center>";
			echo "<meta http-equiv='refresh' content ='1; url=index.php'>";
		}
		
		// Close statement and connection
		mysqli_stmt_close($query);
		mysqli_close($connect);
	}
	else {
		$message = "Field Can't be Left Blank";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo "<center>Redirecting you back to Login Page! If not Goto <a href='index.php'> Here </a></center>";
		echo "<meta http-equiv='refresh' content ='1; url=index.php'>";
	}
?>