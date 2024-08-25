<?php
session_start();
require 'db_connection.php';
// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if not logged in
    header("Location: logout.php");
    exit();
}
$cid = "";
$username = "";
$pass = "";
$full_name = "";
$address = "";
$email = "";
$contact_no = "";


// Handle form submission to update customer details
// Initialize variables to avoid undefined variable warnings


if (isset($_POST["btnupdate"])) {
    $cid = $_POST["cid"];
    $username = $_POST["username"];
    $pass = $_POST["password"];
    $full_name = $_POST["full_name"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $contact_no = $_POST["contact_no"];

   

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use prepared statement to prevent SQL injection
    $query = "UPDATE customer SET Username = ?, Password = ?,Full_Name = ?,Address = ?,Email = ?,Contact_No = ? WHERE CID = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($connection, $query);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssssis", $username, $pass,$full_name,$address, $email,$contact_no , $photo, $cid);
    
    // Execute the statement
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        echo "Number of records updated: " . mysqli_stmt_affected_rows($stmt);
        header("Location: customerprofile.php");
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
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file for styling -->
    <link rel="stylesheet" href="navbarstyle.css">
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
    <h2>Edit Profile</h2>
    <form action="#" method="post">
        <input type="hidden" name="cid" value="<?php echo $_SESSION['UserID']; ?>">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
        <label for="username">Password</label>
        <input type="text" id="password" name="password" value="<?php echo $username; ?>" required>
        
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo $full_name; ?>" required>
        
        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        
        <label for="contact_no">Contact Number</label>
        <input type="tel" id="contact_no" name="contact_no" value="<?php echo $contact_no; ?>" required>

        
        
        
        <input type="submit" name="btnupdate" value="Save Changes">
    </form>
    
    <a href="customerprofile.php">Cancel</a>
</body>
</html>
