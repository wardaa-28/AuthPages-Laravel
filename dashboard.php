<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? '';
$editIndex = $_GET['index'] ?? null;
$usersFile = "users.txt";
$message = "";
$msgType = "";

// ===== Handle Delete =====
if($action == 'delete' && $editIndex !== null){
    $lines = file($usersFile, FILE_IGNORE_NEW_LINES);
    if(isset($lines[$editIndex])){
        unset($lines[$editIndex]);
        file_put_contents($usersFile, implode("\n", $lines)."\n");
        $message = "User deleted successfully!";
        $msgType = "success";
    }
}

// ===== Handle Edit Submission =====
if(isset($_POST['update_user'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $index = $_POST['index'];

    $lines = file($usersFile, FILE_IGNORE_NEW_LINES);
    if(isset($lines[$index])){
        $lines[$index] = "$name-$email-$phone-$password";
        file_put_contents($usersFile, implode("\n", $lines)."\n");
        $message = "User updated successfully!";
        $msgType = "success";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>

<?php if($message != ""): ?>
    <div class="msg <?= $msgType ?>"><?= $message ?></div>
<?php endif; ?>

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
            <a href="dashboard.php?page=home" class="<?= $page == 'home' ? 'active' : '' ?>">Home</a>
            <a href="dashboard.php?page=profile" class="<?= $page == 'profile' ? 'active' : '' ?>">Profile</a>
            <a href="dashboard.php?page=users" class="<?= $page == 'users' ? 'active' : '' ?>">Users</a>
        </aside>

        <!-- ===== CONTENT ===== -->
        <section class="content">

            <?php if ($page == 'home'): ?>
                <div class="home-box">
                    <h2>Welcome to Home 🎉</h2>
                    <p>Hope you are having a great day!</p>
                </div>

            <?php elseif($page == 'profile'): ?>
                <div class="profile-box">
                    <img src="assets/profile.jpg" class="profile-img">
                    <div class="user-info">
                        <p><strong>Name</strong> <span><?= $_SESSION['user'][0] ?></span></p>
                        <p><strong>Email</strong> <span><?= $_SESSION['user'][1] ?></span></p>
                        <p><strong>Phone</strong> <span><?= $_SESSION['user'][2] ?></span></p>
                    </div>
                </div>

            <?php elseif($page == 'users'): ?>
                <h2 style="text-align:center; color:#6a4fb3;">Users Management</h2>

                <?php
                $lines = file($usersFile, FILE_IGNORE_NEW_LINES);
                if(count($lines) > 0):
                ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lines as $i => $line):
                            $data = explode("-", $line);
                        ?>
                        <tr>
                            <td><?= $data[0] ?></td>
                            <td><?= $data[1] ?></td>
                            <td><?= $data[2] ?></td>
                            <td><?= $data[3] ?></td>
                            <td>
                                <a href="dashboard.php?page=users&action=edit&index=<?= $i ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="dashboard.php?page=users&action=delete&index=<?= $i ?>" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p style="text-align:center; color:#6a4fb3;">No users found.</p>
                <?php endif; ?>

                <?php
                // Edit Form
                if($action == 'edit' && $editIndex !== null){
                    if(isset($lines[$editIndex])){
                        $user = explode("-", $lines[$editIndex]);
                        ?>
                        <div class="edit-box">
                            <h3>Edit User</h3>
                            <form method="post">
                                <input type="hidden" name="index" value="<?= $editIndex ?>">
                                Name: <input type="text" name="name" value="<?= $user[0] ?>" required><br>
                                Email: <input type="email" name="email" value="<?= $user[1] ?>" required><br>
                                Phone: <input type="text" name="phone" value="<?= $user[2] ?>" required><br>
                                Password: <input type="text" name="password" value="<?= $user[3] ?>" required><br>
                                <button name="update_user">Update User</button>
                            </form>
                        </div>
                        <?php
                    }
                }
                ?>

            <?php endif; ?>

        </section>
    </div>
</div>
</body>
</html>
