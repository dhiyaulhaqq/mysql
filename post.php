<?php

// Include message library
require('message.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

session_start();

// Check for submit
if (isset($_POST['delete'])) {
    // Get Form Data
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    $query = "DELETE FROM posts WHERE id = {$delete_id}";

    if (mysqli_query($conn, $query)) {
        header('Location: ' . ROOT_URL . 'dashboard.php');
    } else {
        writep($query);
        writep('ERROR: ' . mysqli_error($conn));
    }
}

// Get ID
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Create Query
$query = '
    SELECT
        p.id,
        p.title,
        p.body,
        p.created_at,
        user.id AS userid,
        user.name AS username
    FROM posts p 
    INNER JOIN user
    ON p.user_id = user.id
    WHERE p.id = ' . $id;

// Get Result
$result = mysqli_query($conn, $query);

// Fetch Data
$post = mysqli_fetch_assoc($result);

// Free Result
mysqli_free_result($result);

// Close Connection
mysqli_close($conn);

?>

<?php include('include/header.php'); ?>

<div class="container">
    <?php if (!empty($_SESSION['session_id'])) : ?>
        <div class="d-flex mb-3">
            <a href="<?php echo ROOT_URL . 'dashboard.php' ?>" class="btn btn-danger mr-1">Dashboard</a>
            <a href="<?php echo ROOT_URL ?>" class="btn btn-primary">Home Page</a>
        </div>
    <?php else : ?>
        <a href="<?php echo ROOT_URL ?>" class="btn btn-primary mb-3">Go Back</a>
    <?php endif ?>
    <div class="card border-primary rounded mb-3">
        <div class="card-header">
            <h2 class="text-primary font-weight-normal"><?php echo $post['title']; ?>
                <span class="h6 text-muted">
                    Created by <?php echo $post['username']; ?>
                    on <?php echo $post['created_at']; ?>
                </span>
            </h2>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $post['body']; ?></p>
            <?php if (!empty($_SESSION['session_id'])) : ?>
                <?php if ($post['userid'] === $_SESSION['userid']) : ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo ROOT_URL; ?>editpost.php?id=<?php echo $post['id'] ?>" class="btn btn-outline-primary">Edit Post</a>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                            <input type="hidden" name="delete_id" class="form-control" value="<?php echo $post['id']; ?>">
                            <input type="submit" name="delete" value="Delete" class="btn btn-outline-danger">
                        </form>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>