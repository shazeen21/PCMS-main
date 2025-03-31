<?php
$connect = mysqli_connect("localhost", "root", "peter@272105"); // Establishing Connection with Server
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_select_db($connect, "details"); // Selecting Database from Server

if(isset($_POST['submit'])) { 
    $cname = $_POST['compny'];
    $date = $_POST['date'];
    $campool = $_POST['campool'];
    $poolven = $_POST['pcv'];
    $per = $_POST['sslc'];
    $puagg = $_POST['puagg'];
    $beaggregate = $_POST['beagg'];
    $back = $_POST['curback'];
    $hisofbk = $_POST['hob'];
    $breakstud = $_POST['break'];
    $otherdet = $_POST['odetails'];
    
    if($cname != '' || $date != '') {
        // Use prepared statements to prevent SQL injection
        $query = mysqli_prepare($connect, "INSERT INTO `details`.`addpdrive`(`CompanyName`,`Date`,`C/P`,`PVenue`,`SSLC`,`PU/Dip`,`BE`,`Backlogs`,`HofBacklogs`,`DetainYears`,`ODetails`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        mysqli_stmt_bind_param($query, "sssssssssss", $cname, $date, $campool, $poolven, $per, $puagg, $beaggregate, $back, $hisofbk, $breakstud, $otherdet);
        
        if(mysqli_stmt_execute($query)) {
            echo "<center>Drive Inserted successfully</center>";
            mysqli_stmt_close($query);
        } else {
            die("FAILED: " . mysqli_error($connect));
        }
    } else {
        die("Field Cannot be left blank");
    }
} else {
    die("You don't have Privileges");
}

mysqli_close($connect);
?>