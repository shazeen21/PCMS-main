<?php
$conn = mysqli_connect('localhost', "root", "peter@272105", 'details');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$uploadOk = 1;
$uploadMessage = "";

// Check if form was submitted
if(isset($_POST["submit"])) {
    $target_dir = "uploads/";
    
    // Generate a unique filename to prevent overwrites
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $targetFilePath = $target_dir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
    // Get other form fields if they exist
    $subject = isset($_POST['Subject']) ? $_POST['Subject'] : '';
    $msg = isset($_POST['Message']) ? $_POST['Message'] : '';
    
    // Check if image file is an actual image
    if(isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"]["tmp_name"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadMessage .= "File is an image - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            $uploadMessage .= "File is not an image.<br>";
            $uploadOk = 0;
        }
        
        // Check file size (500KB limit)
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $uploadMessage .= "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadMessage .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }
        
        // Check if file already exists and generate a unique name if it does
        if (file_exists($targetFilePath)) {
            $fileName = time() . '_' . $fileName; // Add timestamp to make filename unique
            $targetFilePath = $target_dir . $fileName;
            $uploadMessage .= "File renamed to avoid overwriting existing file.<br>";
        }
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $uploadMessage .= "Sorry, your file was not uploaded.<br>";
        } else {
            // Try to upload file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
                $uploadMessage .= "The file ". htmlspecialchars($fileName). " has been uploaded.<br>";
                
                // Prepare and execute the database insertion using prepared statement
                $stmt = mysqli_prepare($conn, "INSERT INTO image (id, image_path) VALUES (NULL, ?)");
                mysqli_stmt_bind_param($stmt, "s", $targetFilePath);
                
                if(mysqli_stmt_execute($stmt)) {
                    $uploadMessage .= "File information uploaded to database successfully.<br>";
                } else {
                    $uploadMessage .= "Error: " . mysqli_error($conn) . "<br>";
                }
                
                mysqli_stmt_close($stmt);
            } else {
                $uploadMessage .= "Sorry, there was an error uploading your file.<br>";
            }
        }
    } else {
        $uploadMessage .= "Please select a file to upload.<br>";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Upload Result</title>
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="message <?php echo ($uploadOk == 1) ? 'success' : 'error'; ?>">
        <?php echo $uploadMessage; ?>
    </div>
    <a href="javascript:history.back()">Go Back</a>
</body>
</html>