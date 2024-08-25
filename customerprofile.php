<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if not logged in
    header("Location: logout.php");
    exit();
}

$cid = $_SESSION['UserID'];

// Retrieve customer details from database
require 'db_connection.php'; // Adjust path as necessary

$select_query = "SELECT Username, Password, Full_name, Address, Email, Contact_no, picture FROM customer WHERE CID = ?";
$stmt = mysqli_prepare($connection, $select_query);
mysqli_stmt_bind_param($stmt, "s", $cid);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $username, $password, $full_name, $address, $email, $contact_no, $picture);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file for styling -->
    <link rel="stylesheet" href="navbarstyle.css">
    <link rel="stylesheet" href="customerprofile.css">

</head>
<body>
<div class="nav justify-content-center">
    <div class="head">
        <h2>Profile</h2>
    </div>
   
    <div class="nav-items">
        <ul>
            <li class="nav-item"><a class="nav-link" href="customer.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="view_cart.php">View cart</a></li>
            <li class="nav-item"><a class="nav-link" href="customerprofile.php">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="review.php">Review</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
    <div class="profile-card">
        <?php if ($picture): ?>
            <img src="<?php echo htmlspecialchars($picture); ?>" alt="Doctor Photo" class="doctor-photo">
        <?php else: ?>
            <img src="profile.png" alt="Default Profile Picture">
        <?php endif; ?>
        <h2><?php echo $full_name; ?></h2>
        <p><strong>Username:</strong> <?php echo $username; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Contact Number:</strong> <?php echo $contact_no; ?></p>
        
        <form action="edit_customerprofile.php" method="post">
            <input type="hidden" name="cid" value="<?php echo $cid; ?>">
            <button type="submit">Edit Profile</button>
        </form>
        
        <form action="upload_photo.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="cid" value="<?php echo $cid; ?>">
            <input type="file" name="profile_photo" accept="image/*"> <!-- Accept only image files -->
            <button type="submit">Upload Photo</button>
        </form>
    </div>
    
</body>
</html>
