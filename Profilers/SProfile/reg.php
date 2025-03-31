<?php
   // Establishing Connection with Server using MySQLi
   $connect = mysqli_connect("localhost", "root", "peter@272105", "details");
   
   // Check connection
   if (!$connect) {
       die("Connection failed: " . mysqli_connect_error());
   }
   
if(isset($_POST['submit']))
{ 
    $Name = $_POST['Fullname'];
    $USN = $_POST['USN'];
    $password = $_POST['PASSWORD'];
    $repassword = $_POST['repassword'];
    $Email = $_POST['Email'];
    $Question = $_POST['Question'];
    $Answer = $_POST['Answer'];
  
    // Check if USN already exists - using prepared statement
    $check_stmt = mysqli_prepare($connect, "SELECT * FROM slogin WHERE USN = ?");
    mysqli_stmt_bind_param($check_stmt, "s", $USN);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if(mysqli_stmt_num_rows($check_stmt) == 0) 
    {
        mysqli_stmt_close($check_stmt);
        
        if($repassword == $password)
        {
            // Insert new user - using prepared statement
            $insert_stmt = mysqli_prepare($connect, "INSERT INTO slogin(Name, USN, PASSWORD, Email, Question, Answer) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert_stmt, "ssssss", $Name, $USN, $password, $Email, $Question, $Answer);
            
            if(mysqli_stmt_execute($insert_stmt))
            {
                echo "<center>You have registered successfully...!! Go back to</center>";
                echo "<center><a href='index.php'>Login here</a></center>";
            } else {
                echo "<center>Registration failed: " . mysqli_error($connect) . "</center>";
            }
            
            mysqli_stmt_close($insert_stmt);
        }
        else
        {
            echo "<center>Your password do not match</center>";
        }
    }
    else
    {
        echo "<center>This USN already exists</center>"; 
        mysqli_stmt_close($check_stmt);
    }
}

// Close connection
mysqli_close($connect);
?>