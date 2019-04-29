<?php

// Include debugging tool
require('debugging.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

// Check for submit
if (isset($_POST['submit'])) {
    // Get Form Data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);

    $query = "INSERT INTO posts(title, author, body) VALUES ('$title', '$author', '$body')";
    if (mysqli_query($conn, $query)) {
        header('Location: ' . ROOT_URL . '');
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
            <input type="text" name="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="author" class="form-control">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea type="text" name="body" class="form-control"></textarea>
        </div>
        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
    </form>
</div>

<?php include('include/footer.php'); ?> 