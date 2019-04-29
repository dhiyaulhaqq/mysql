<?php

// Include debugging tool
require('debugging.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

// Create Query
$query = 'SELECT * FROM posts ORDER BY created_at DESC';

// Get Result
$result = mysqli_query($conn, $query);

// Fetch Data
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
// writep($posts);
// Free Result
mysqli_free_result($result);

// Close Connection
mysqli_close($conn);

?>

<?php include('include/header.php'); ?>

<div class="container">
    <h1 class="display-4">Posts</h1>
    <?php foreach ($posts as $post) : ?>
    <div class="card border-primary rounded mb-3">
        <div class="card-header">
            <h3 class="text-primary font-weight-normal"><?php echo $post['title']; ?>
                <span class="h6 text-muted">
                    Created by <?php echo $post['author']; ?>
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
</div>

<?php include('include/footer.php'); ?> 