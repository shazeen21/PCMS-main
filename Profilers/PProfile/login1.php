<?php
    session_start();
    $pusername = $_POST['username'];
    $password  = $_POST['password'];

    if ($pusername && $password) {
        // Use mysqli instead of deprecated mysql functions
        $connect = mysqli_connect("localhost", "root", "Peter@272105", "details");
        
        // Check connection
        if (!$connect) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        // Use prepared statements to prevent SQL injection
        $stmt = $connect->prepare("SELECT * FROM plogin WHERE Username=?");
        $stmt->bind_param("s", $pusername);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $numrows = $result->num_rows;
        
        if ($numrows != 0) {
            $row = $result->fetch_assoc();
            $dbusername = $row['Username'];
            $dbpassword = $row['Password'];
            
            if ($pusername == $dbusername && $password == $dbpassword) {
                echo "<center>Login Successful..!! <br/>Redirecting you to HomePage! </br>If not Goto <a href='index.php'> Here </a></center>";
                echo "<meta http-equiv='refresh' content ='3; url=index.php'>";
                $_SESSION['pusername'] = $pusername;
            } else {
                $message = "Username and/or Password incorrect.";
                echo "<script type='text/javascript'>alert('$message');</script>";
                echo "<center>Redirecting you back to Login Page! If not Goto <a href='index.php'> Here </a></center>";
                echo "<meta http-equiv='refresh' content ='1; url=index.php'>";
            }
        } else {
            echo "<center>User does not exist. <br/>Redirecting you back to Login Page! </br>If not Goto <a href='index.php'> Here </a></center>";
            echo "<meta http-equiv='refresh' content ='2; url=index.php'>";
        }
        
        // Close connection
        $stmt->close();
        $connect->close();
    } else {
        header("location: index.php");
        exit;
    }
?>