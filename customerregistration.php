<?php

require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST["txtusername"];
    $pass = $_POST["txtpass"];
    $fullname = $_POST["txtfullname"];
    $address = $_POST["txtaddress"];
    $email = $_POST["txtemail"];
    $contact = $_POST["txtcontact"];

   
    

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Auto-increment CID
    $query = "SELECT MAX(CID) AS max_cid FROM customer";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $max_cid = $row['max_cid'];
    $next_cid = 'C001';

    if ($max_cid) {
        $next_num = intval(substr($max_cid, 1)) + 1;
        $next_cid = 'C' . str_pad($next_num, 3, '0', STR_PAD_LEFT);
    }

    $query = "INSERT INTO customer (CID, Username, Password, Full_name, Address, Email, Contact_no) VALUES ('$next_cid', '$uname', '$pass', '$fullname', '$address', '$email', $contact)";
    
    if (mysqli_query($connection, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="signup.css">

</head>
<body>
    <section>
        <form action="#" method="post">
            <h1>Customer Registration</h1>
            <div class="inputbox">
                <input type="text" name="txtusername" required placeholder="Username">
            </div>
            <div class="inputbox">
                <input type="password" name="txtpass" required placeholder="Password">
            </div>
            <div class="inputbox">
                <input type="text" name="txtfullname" required placeholder="Full Name">
            </div>
            <div class="inputbox">
                <input type="text" name="txtaddress" required placeholder="Address">
            </div>
            <div class="inputbox">
                <input type="email" name="txtemail" required placeholder="Email">
            </div>
            <div class="inputbox">
                <input type="text" name="txtcontact" required placeholder="Contact Number">
            </div>
            <button type="submit" class="btn">Register</button>
            <a href="index.php">Back To Login</a>
        </form>
    </section>
</body>
</html>
