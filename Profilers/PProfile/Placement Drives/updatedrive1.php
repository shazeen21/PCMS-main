<?php
$connect = mysqli_connect("localhost", "root", "peter@272105");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_select_db($connect, "details");

if(isset($_POST['submit'])) {
    $usn = $_POST['usn'];
    echo "$usn";
    $name = $_POST['sname']; //Keep sname since that is the variable name
    $comname = $_POST['comname'];
    $date = $_POST['Date'];
    $attend = $_POST['Attendance'];
    $wt = $_POST['WrittenTest'];
    $gd = $_POST['GD'];
    $tech = $_POST['Tech'];
    $placed = $_POST['Placed'];

    // Correct the column name here
    $query = mysqli_prepare($connect, "INSERT INTO updatedrive(USN, sname, CompanyName, Date, Attendence, WT, GD, Techical, Placed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($query, "sssssssss", $usn, $name, $comname, $date, $attend, $wt, $gd, $tech, $placed);

    if(mysqli_stmt_execute($query)) {
        echo "<center>Data Inserted successfully...!!</center>";
        mysqli_stmt_close($query);
    } else {
        echo "<center>FAILED: " . mysqli_error($connect) . "</center>";
    }

    mysqli_close($connect);
}
?>