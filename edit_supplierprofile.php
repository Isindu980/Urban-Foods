<?php
session_start();
require 'db_connection.php';
// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if not logged in
    header("Location: logout.php");
    exit();
}
$sid = "";
$username = "";
$pass = "";
$full_name = "";
$email = "";
$contact_no = "";


// Handle form submission to update customer details
// Initialize variables to avoid undefined variable warnings


if (isset($_POST["btnupdate"])) {
    $sid = $_POST["sid"];
    $username = $_POST["username"];
    $pass = $_POST["password"];
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $contact_no = $_POST["contact_no"];

   

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use prepared statement to prevent SQL injection
    $query = "UPDATE supplierlogin SET Username = ?, Password = ?,Full_Name = ?,Email = ?,Contact_Number = ? WHERE SID = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($connection, $query);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssis", $username, $pass,$full_name, $email,$contact_no , $sid);
    
    // Execute the statement
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        echo "Number of records updated: " . mysqli_stmt_affected_rows($stmt);
        header("Location: supplierprofile.php");
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }

    // Clean up statement
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="navbarstyle.css">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file for styling -->
    <style>
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type=text], input[type=email], input[type=tel] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type=submit] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="nav justify-content-center">
    <div class="head">
        <h2>Profiel</h2>
    </div>
   
    <div class="nav-items">
        <ul>
            <li class="nav-item"><a class="nav-link" href="supplierprofile.php">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="supplierpanel.php">Add Items</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
    <h2>Edit Profile</h2>
    <form action="#" method="post">
        <input type="hidden" name="cid" value="<?php echo $_SESSION['UserID']; ?>">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
        <label for="username">Password</label>
        <input type="text" id="password" name="password" value="<?php echo $username; ?>" required>
        
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo $full_name; ?>" required>
        
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        
        <label for="contact_no">Contact Number</label>
        <input type="tel" id="contact_no" name="contact_no" value="<?php echo $contact_no; ?>" required>

        
        
        
        <input type="submit" name="btnupdate" value="Save Changes">
    </form>
    
    <a href="supplierprofile.php">Cancel</a>
</body>
</html>
