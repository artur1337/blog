<?php
$conn = mysqli_connect("localhost","root","user123","blog_db");
if(mysqli_connect_error()){
    echo "Failed to connect to MySQL : " . mysqli_connect_error();
}