<?php

// Include message library
require('message.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

session_start();

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
    ORDER BY p.created_at DESC';

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

// writep($posts);

// Close Connection
mysqli_close($conn);

?>

<?php include('include/header.php'); ?>

<div class="container">
    <div class="jumbotron text-center mb-3">
        <h1 class="display-4">PHP BLOG</h1>
        <p>This is my blog app using PHP and MySQL created by Iqbal</p>
    </div>
</div>

<div class="container">
    <h1 class="display-4">Posts</h1>
    <?php if ($posts) : ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) : ?>
                    <tr>
                        <td>
                            <a href="<?php echo ROOT_URL . 'post.php?id=' . $post['id'] ?>" class="text-dark"><?php echo $post['title'] ?></a>
                        </td>
                        <td><?php echo $post['username'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No Post</p>
    <?php endif ?>
</div>

<?php include('include/footer.php'); ?>