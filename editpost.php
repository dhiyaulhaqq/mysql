<?php

// Include message library
require('message.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

session_start();

// check authorization
if (empty($_SESSION['session_id'])) {
    echo 'You are not login <br>';
    var_dump(isset($_SESSION));
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
    exit();
    header('Location: ' . ROOT_URL . 'login.php');
}

// Check for submit
if (isset($_POST['submit'])) {
    // Get Form Data
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);

    $query = "UPDATE posts SET
            title = '$title',
            body = '$body'
            WHERE id = {$post_id} ";

    if (mysqli_query($conn, $query)) {
        header('Location: ' . ROOT_URL . 'post.php?id=' . $post_id);
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
    <h1 class="display-4">Edit Post</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $post['title']; ?>" required>
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea type="text" name="body" class="form-control" required><?php echo $post['body']; ?></textarea>
        </div>
        <input type="hidden" name="post_id" class="form-control" value="<?php echo $post['id']; ?>">
        <input type="submit" name="submit" value="Update" class="btn btn-primary">
        <a href="<?php echo ROOT_URL; ?>post.php?id=<?php echo $post['id']; ?>" class="btn btn-warning">Cancel</a>
    </form>
</div>

<?php include('include/footer.php'); ?>