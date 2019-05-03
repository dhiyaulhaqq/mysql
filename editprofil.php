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
$userid = $_SESSION['userid'];

// Check for submit
if (isset($_POST['submit'])) {
    // Get Form Data
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $query = "UPDATE user SET
            name = '$name'
            WHERE id = {$userid} ";

    if (mysqli_query($conn, $query)) {
        header('Location: ' . ROOT_URL . 'profil.php');
    } else {
        writep($query);
        writep('ERROR: ' . mysqli_error($conn));
    }
}

// Create Query
$query = 'SELECT * FROM user WHERE id = ' . $userid;

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
    <h1 class="display-4">Edit Profil</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="<?php echo $user['name'] ?>" class="form-control">
        </div>
        <input type="submit" name='submit' value="Update" class="btn btn-primary">
        <a href="<?php echo ROOT_URL; ?>profil.php?id=<?php echo $user['id']; ?>" class="btn btn-warning">Cancel</a>
    </form>
</div>

<?php include('include/footer.php'); ?>