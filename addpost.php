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
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);

    $query = "INSERT INTO posts(title, author, body) VALUES ('$title', '$author', '$body')";
    if (mysqli_query($conn, $query)) {
        header('Location: ' . ROOT_URL . 'dashboard.php');
    } else {
        writep($query);
        writep('ERROR: ' . mysqli_error($conn));
    }
}

?>

<?php include('include/header.php'); ?>

<div class="container">
    <h1 class="display-4">Add Post</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea type="text" name="body" class="form-control" required></textarea>
        </div>
        <input type="submit" name="submit" value="Save" class="btn btn-primary">
        <a href="<?php echo ROOT_URL . 'dashboard.php' ?>" class="btn btn-warning">Cancel</a>
    </form>
</div>

<?php include('include/footer.php'); ?>