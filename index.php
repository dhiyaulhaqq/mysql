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
    <h1 class="display-4">Posts</h1>
    <?php if ($posts) : ?>
        <?php foreach ($posts as $post) : ?>
            <div class="card border-primary rounded mb-3">
                <div class="card-header">
                    <h3 class="text-primary font-weight-normal"><?php echo $post['title']; ?>
                        <span class="h6 text-muted">
                            Created by <?php echo $post['username']; ?>
                            on <?php echo $post['created_at']; ?>
                        </span>
                    </h3>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo $post['body']; ?></p>
                    <a class="btn btn-outline-primary" href="<?php echo ROOT_URL; ?>post.php?id=<?php echo $post['id']; ?>">Read More...</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No Post</p>
    <?php endif ?>
</div>

<?php include('include/footer.php'); ?>