<?php

// Include debugging tool
require('debugging.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

// Check for submit
if (isset($_POST['delete'])) {
    // Get Form Data
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    $query = "DELETE FROM posts WHERE id = {$delete_id}";

    if (mysqli_query($conn, $query)) {
        header('Location: ' . ROOT_URL . '');
    } else {
        writep($query);
        writep('ERROR: ' . mysqli_error($conn));
    }
}

// Get ID
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Create Query
$query = 'SELECT * FROM posts WHERE id = ' . $id;

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
    <div class="card border-primary rounded mb-3">
        <div class="card-header">
            <h2 class="text-primary font-weight-normal"><?php echo $post['title']; ?>
                <span class="h6 text-muted">
                    Created by <?php echo $post['author']; ?>
                    on <?php echo $post['created_at']; ?>
                </span>
            </h2>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $post['body']; ?></p>
            <hr>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="float-right">
                <input type="hidden" name="delete_id" class="form-control" value="<?php echo $post['id']; ?>">
                <input type="submit" name="delete" value="Delete" class="btn btn-outline-danger">
            </form>
            <a href="<?php echo ROOT_URL; ?>editpost.php?id=<?php echo $post['id'] ?>" class="btn btn-outline-primary">Edit Post</a>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?> 