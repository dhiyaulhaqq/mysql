<?php

// Include message library
require('message.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

session_start();

$error = false;
$valid = false;

// Check for submit
if (isset($_POST['submit'])) {
    // Get users data
    $query = 'SELECT * FROM user';

    // Get Result
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch Data
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Free Result
        mysqli_free_result($result);
    } else {
        $users = [];
    }

    // get users email list
    $list_email = array_map(function ($user) {
        return $user['email'];
    }, $users);

    // Get Form Data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // check for existing email
    if (in_array($email, $list_email)) {
        $valid = true;
    } else {
        $error = 'User email not found';
    }

    // check for password
    if ($valid) {
        // get user data
        $user = array_filter($users, function ($user) use ($email) {
            return $user['email'] === $email;
        });

        $user = array_pop($user);
        $user_password = $user['password'];
        $username = $user['name'];
        $userid = $user['id'];

        if (password_verify($password, $user_password)) {
            // authorization
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $userid;
            header('Location: ' . ROOT_URL . 'dashboard.php');
        } else {
            $error = 'Invalid password';
        }
    }

    // Close Connection
    mysqli_close($conn);
}

?>

<?php include('include/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="display-4">Login</h1>
            <hr>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" class="form-control <?= (stristr($error, 'email')) ? 'border-danger text-danger bg-light' : '' ?>" required>
                    <?php if (stristr($error, 'email')) : ?>
                        <span class="text-danger">
                            <strong><?= $error ?></strong>
                        </span>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control <?= (stristr($error, 'password')) ? 'border-danger text-danger bg-light' : '' ?>" required>
                    <?php if (stristr($error, 'password')) : ?>
                        <span class="text-danger">
                            <strong><?= $error ?></strong>
                        </span>
                    <?php endif ?>
                </div>
                <input type="submit" name="submit" value="Login" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>