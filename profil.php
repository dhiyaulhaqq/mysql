<?php

// Include message library
require('message.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

session_start();

if (empty($_SESSION['session_id'])) {
    header('Location: ' . ROOT_URL . 'login.php');
}

// Get ID
$id = $_SESSION['userid'];

// Create Query
$query = 'SELECT * FROM user WHERE id = ' . $id;

// Get Result
$result = mysqli_query($conn, $query);

// Fetch Data
$user = mysqli_fetch_assoc($result);

// Free Result
mysqli_free_result($result);

// Close Connection
mysqli_close($conn);

?>

<?php include('include/header.php'); ?>

<div class="container">
    <h1 class="display-4"><?php echo $user['name'] ?></h1>
    <p><?php echo $user['email'] ?></p>
</div>

<?php include('include/footer.php'); ?>