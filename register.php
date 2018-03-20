<?php include('functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
</head>
<body>
<h2>Register</h2>
<form method="post" action="register.php">
    <?php echo display_error(); ?>
    <lable>User name</lable><br>
    <input name="username" type="text" value="<?php echo $username; ?>"><br>
    <lable>Email</lable><br>
    <input name="email" type="email" value="<?php echo $email; ?>"><br>
    <lable>Password</lable><br>
    <input name="password_1" type="password"><br>
    <lable>Repeat password</lable><br>
    <input name="password_2" type="password"><br>
    <button name="register_btn" type="submit">Register</button>
    <p>
        Already a member? <a href="login.php">Sing in</a>
    </p>
</form>
</body>
</html>