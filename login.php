<?php
session_start();

$error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $file = fopen("users.txt", "r");
    $found = false;

    while(!feof($file)){
        $line = fgets($file);
        $data = explode("-", trim($line));

        if(isset($data[1]) && $data[1] == $email && $data[3] == $password){
            $_SESSION['user'] = $data;
            $found = true;
            break;
        }
    }
    fclose($file);

    if($found){
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form method="post">
    <h2>Login</h2>

    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button name="login">Login</button>

    <p class="link-text">
        Don’t have an account?
        <a href="signup.php">Signup here</a>
    </p>
</form>

</body>
</html>
