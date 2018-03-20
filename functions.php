<?php

session_start();

include('connect_sql.php');

$username = "";
$email = "";
$errors = array();

if (isset($_POST['register_btn'])) {
    register();
}

function register()
{

    global $conn, $errors, $username, $email;

    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $password_1 = escape($_POST['password_1']);
    $password_2 = escape($_POST['password_2']);

    // from validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "User is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    if (count($errors) == 0) {
        $password = md5($password_1);// encrypt the password before saving in database

        if(isset($_POST['user_type'])) {
            $user_type = escape($_POST['user_type']);
            $query = "INSERT INTO users (username, email, user_type, password) VALUES('$username', '$email', '$user_type', '$password')";
            mysqli_query($conn, $query);
            $_SESSION['success'] = "New user successfully created!!";
            header('location: home.php');
        }else{
            $query = "INSERT INTO users (username, email, user_type, password) VALUES('$username', '$email', 'user', '$password')";
            mysqli_query($conn, $query);

            $logged_in_user_id = mysqli_insert_id($conn);

            $_SESSION['user'] = getUserById($logged_in_user_id);
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
    }
}

function getUserById($id){
    global $conn;
    $query = "SELECT * FROM users WHERE id=" . $id;
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

function escape($val){
    global $conn;
    return mysqli_real_escape_string($conn, trim($val));
}

function display_error(){
    global $errors;

    if(count($errors) > 0){
        echo '<div class="error">';
        foreach ($errors as $error){
            echo $error .'<br>';
        }
        echo '</div>';
    }
}

function isLoggedIn(){
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

if(isset($_POST['login_btn'])){
    login();
}

function login(){
    global $conn, $username, $errors;

    $username = escape($_POST['username']);
    $password = escape($_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
        $password = md5($password);

        $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($conn, $query);

        if (mysqli_num_rows($results) == 1) {
            $logged_in_user = mysqli_fetch_assoc($results);
            if ($logged_in_user['user_type'] == 'admin') {

                $_SESSION['user'] = $logged_in_user;
                $_SESSION['success'] = "You are now logged in";

                header('location: admin/home.php');
            } else {
                $_SESSION['user'] = $logged_in_user;
                $_SESSION['success'] = "You are now logged in";

                header('location: index.php');
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}