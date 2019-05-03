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

// Check for delete submit
if (isset($_POST['delete'])) {
    // Get Form Data
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    $query = "DELETE FROM posts WHERE id = {$delete_id}";

    if (!mysqli_query($conn, $query)) {
        writep($query);
        writep('ERROR: ' . mysqli_error($conn));
    }
}

// Create Query
$query = "SELECT * FROM posts WHERE user_id = {$_SESSION['userid']} ORDER BY created_at DESC";

// Get Result
$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch Data
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // Free Result
    mysqli_free_result($result);
} else {
    $posts = null;
}

// Close Connection
mysqli_close($conn);

?>

<?php include('include/header.php'); ?>

<div class="container">
    <h1 class="display-4">Dashboard</h1>
    <hr>
    <a href="<?php echo ROOT_URL; ?>addpost.php" class="btn btn-primary mb-3">Add Post</a>
    <h3>Your Blog Post</h3>
    <?php if ($posts) : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) : ?>
                    <tr>
                        <td><a href="<?php echo ROOT_URL . 'post.php?id=' . $post['id'] ?>" class="text-dark"><?php echo $post['title']; ?></a></td>
                        <td><?php echo $post['created_at']; ?></td>
                        <td class="d-flex">
                            <a href="<?php echo ROOT_URL; ?>editpost.php?id=<?php echo $post['id'] ?>" class="btn btn-primary mr-1">Edit</a>
                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                                <input type="hidden" name="delete_id" class="form-control" value="<?php echo $post['id']; ?>">
                                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No Post</p>
    <?php endif ?>
</div>

<?php include('include/footer.php'); ?>