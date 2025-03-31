<?php
session_start(); // Added session_start as it's using $_SESSION

$conn = mysqli_connect('localhost', "root", "peter@272105", 'details');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['update'])) { 
    // Get form data
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $USN = $_POST['USN'];
    $username = $_SESSION["username"]; // Using the session variable correctly
    $phno = $_POST['Num'];
    
    // Get additional form fields that were referenced in the update query but missing in the input section
    $email = isset($_POST['Email']) ? $_POST['Email'] : '';
    $date = isset($_POST['DOB']) ? $_POST['DOB'] : '';
    $cursem = isset($_POST['Sem']) ? $_POST['Sem'] : '';
    $branch = isset($_POST['Branch']) ? $_POST['Branch'] : '';
    $per = isset($_POST['SSLC']) ? $_POST['SSLC'] : '';
    $puagg = isset($_POST['PU/Dip']) ? $_POST['PU/Dip'] : '';
    $beaggregate = isset($_POST['BE']) ? $_POST['BE'] : '';
    $back = isset($_POST['Backlogs']) ? $_POST['Backlogs'] : '';
    $hisofbk = isset($_POST['HofBacklogs']) ? $_POST['HofBacklogs'] : '';
    $detyear = isset($_POST['DetainYears']) ? $_POST['DetainYears'] : '';
    
    // Variable for student's USN validation (was referenced but not defined)
    $sun = isset($_SESSION['sun']) ? $_SESSION['sun'] : $USN;

    if($USN != '' || $email != '') {
        if($USN == $sun) {
            // Using mysqli prepared statement to prevent SQL injection
            $sql = "SELECT * FROM `basicdetails` WHERE `USN`=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $USN);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if(mysqli_num_rows($result) == 1) {
                // Prepare the update statement
                $update_sql = "UPDATE `basicdetails` SET 
                    `FirstName`=?, 
                    `LastName`=?, 
                    `Mobile`=?, 
                    `Email`=?, 
                    `DOB`=?, 
                    `Sem`=?, 
                    `Branch`=?, 
                    `SSLC`=?, 
                    `PU/Dip`=?, 
                    `BE`=?, 
                    `Backlogs`=?, 
                    `HofBacklogs`=?, 
                    `DetainYears`=?, 
                    `Approve`='0' 
                    WHERE `USN`=?";
                
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "ssssssssssssss", 
                    $fname, $lname, $phno, $email, $date, $cursem, $branch, 
                    $per, $puagg, $beaggregate, $back, $hisofbk, $detyear, $USN);
                
                if(mysqli_stmt_execute($update_stmt)) {
                    echo "<center>Data Updated successfully...!!</center>";
                } else {
                    echo "<center>FAILED: " . mysqli_error($conn) . "</center>";
                }
                
                mysqli_stmt_close($update_stmt);
            } else {
                echo "<center>NO record found for update</center>";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "<center>Enter your USN only</center>";
        }
    } else {
        echo "<center>USN or Email is required</center>";
    }
}

mysqli_close($conn);
?>