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

// Check for submit
if (isset($_POST['yes'])) {
    // Get Form Data
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    $query = "DELETE FROM user WHERE id = {$user_id}";

    if (mysqli_query($conn, $query)) {
        // release authorization
        session_unset();
        session_destroy();
        header('Location: ' . ROOT_URL . '');
    } else {
        writep($query);
        writep('ERROR: ' . mysqli_error($conn));
    }
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
    <a href="<?php echo ROOT_URL . 'editprofil.php' ?>" class="btn btn-primary mb-3">Edit profil</a>
    <h1 class="display-4"><?php echo $user['name'] ?></h1>
    <p><?php echo $user['email'] ?></p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="submit" name="delete" value="Delete Account" class="btn btn-outline-danger mb-3">
    </form>
    <?php if (isset($_POST['delete'])) : ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <p>Are you sure?</p>
            <input type="hidden" name="user_id" class="form-control" value="<?php echo $user['id']; ?>">
            <input type="submit" name="yes" value="Yes" class="btn btn-danger">
            <input type="submit" name="no" value="No" class="btn btn-warning">
        </form>
    <?php endif ?>
</div>

<?php include('include/footer.php'); ?>