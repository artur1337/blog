<?php include('functions.php');?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>
<h2>Login</h2>
<form method="post" action="login.php">
    <?php echo display_error(); ?>
    <label>User name</label><br>
    <input name="username" type="text"><br>
    <label>Password</label><br>
    <input name="password" type="password"><br>
    <button name="login_btn" type="submit">Login</button>
    <p>
        Not yet a member? <a href="register.php">Sing up</a>
    </p>
</form>
</body>
</html>