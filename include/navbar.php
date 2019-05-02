<nav class="navbar navbar-expand-sm navbar-dark bg-primary mb-3">
    <div class="container">
        <a href="<?php echo ROOT_URL; ?>" class="navbar-brand">PHPBlog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobile-nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mobile-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="<?php echo ROOT_URL; ?>" class="nav-link">Home</a>
                </li>
                <?php if (!empty($_SESSION['session_id'])) : ?>
                    <li class="nav-item">
                        <a href="<?php echo ROOT_URL; ?>dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ROOT_URL; ?>logout.php" class="nav-link">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ROOT_URL . 'profil.php' ?>" class="nav-link"><?php echo $_SESSION['username'] ?></a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="<?php echo ROOT_URL; ?>login.php" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo ROOT_URL; ?>register.php" class="nav-link">Register</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>