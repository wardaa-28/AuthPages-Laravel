<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="app-container">

    <!-- ===== HEADER ===== -->
    <header class="app-header">
        <h1>My Dashboard</h1>
        <a href="logout.php" class="logout-top">Logout</a>
    </header>

    <!-- ===== MAIN ===== -->
    <div class="main-layout">

        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar">
            <a href="dashboard.php?page=home" class="<?= $page == 'home' ? 'active' : '' ?>"> Home</a>
            <a href="dashboard.php?page=profile" class="<?= $page == 'profile' ? 'active' : '' ?>"> Profile</a>
        </aside>

        <!-- ===== CONTENT ===== -->
        <section class="content">

            <?php if ($page == 'home'): ?>
                <div class="home-box">
                    <h2>Welcome to Home 🎉</h2>
                    <p>Hope you are having a great day!</p>
                </div>
            <?php else: ?>
                <div class="profile-box">

                    <img src="assets/profile.jpg" class="profile-img">

                    <div class="user-info">
                        <p><strong>Name</strong> <span><?php echo $_SESSION['user'][0]; ?></span></p>
                        <p><strong>Email</strong> <span><?php echo $_SESSION['user'][1]; ?></span></p>
                        <p><strong>Phone</strong> <span><?php echo $_SESSION['user'][2]; ?></span></p>
                    </div>

                </div>
            <?php endif; ?>

        </section>

    </div>
</div>

</body>
</html>
