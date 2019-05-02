<?php

// Include message library
require('message.php');

// Include database and configuration
require('config/config.php');
require('config/db.php');

session_start();

$error = false;

// Check for submit
if (isset($_POST['submit'])) {
    // Get users data
    $query = 'SELECT * FROM user';

    // Get Result
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch Data
        $user = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Free Result
        mysqli_free_result($result);
    } else {
        $user = [];
    }

    $list_email = array_map(function ($user) {
        return $user['email'];
    }, $user);

    // Get Form Data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);


    if ($password !== $confirm_password) {
        $error = 'The password confirmation does not match.';
    }

    if (strlen($password) < 8) {
        $error = 'The password must be at least 8 characters.';
    }

    // check for existing email
    if (in_array($email, $list_email)) {
        $error = 'Email has already been taken';
    }

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    if (!$error) {
        $query = "INSERT INTO user(name, email, password) VALUES ('$name', '$email', '$hash_password')";
        if (mysqli_query($conn, $query)) {
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            header('Location: ' . ROOT_URL . 'dashboard.php');
        } else {
            writep($query);
            writep('ERROR: ' . mysqli_error($conn));
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
            <h1 class="display-4">Register User</h1>
            <hr>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>" class="form-control" required>
                </div>
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
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" name="confirm-password" class="form-control" required>
                </div>
                <input type="submit" name="submit" value="Register" class="btn btn-primary w-100">
            </form>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>