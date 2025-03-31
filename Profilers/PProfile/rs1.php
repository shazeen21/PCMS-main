<?php
	session_start();
	
	$USN1 = $_POST['USN'];
	$password = $_POST['PASSWORD'];
	$confirm = $_POST['repassword'];
	
	$conn = mysqli_connect('localhost', "root", "peter@272105", 'details');
	if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
	}
	
	if($password == $confirm) {
		if($sql ="UPDATE `placement`.`plogin` SET `Password` ='$password' WHERE `plogin`.`Username` = '$USN1'");
		echo "<center>Password Reset Complete</center>";
		session_unset();
	} else
	echo "Update Failed";
?>