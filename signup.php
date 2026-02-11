<?php
$message = "";
$msgType = "";

if(isset($_POST['signup'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $file = fopen("users.txt", "a+");
    rewind($file);
    $exists = false;

    while(!feof($file)){
        $line = fgets($file);
        $data = explode("-", trim($line));  // changed to - to match your fwrite

        if(isset($data[1]) && $data[1] == $email){
            $exists = true;
            break;
        }
    }

    if($exists){
        $message = "User already registered!";
        $msgType = "error";
    } else {
        $userData = "$name-$email-$phone-$password\n";
        fwrite($file, $userData);
        $message = "Signup successful!";
        $msgType = "success";
    }

    fclose($file);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if($message != ""): ?>
    <div class="msg <?= $msgType ?>">
        <?= $message ?>
    </div>
<?php endif; ?>

<form method="post" class="signup-form">
    <h2>Signup</h2>
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Phone: <input type="text" name="phone" required><br>
    Password: <input type="password" name="password" required><br>

    <button name="signup">Signup</button>
    <br><br>

    Already have an account?
    <a href="login.php">Login here</a>
</form>

</body>
</html>
