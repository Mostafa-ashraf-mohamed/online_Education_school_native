<?php
$host = "localhost";
$user="root";
$password="";
$dbName="school";
$conn = mysqli_connect($host,$user,$password,$dbName);

 function test_input($data)
 {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars ($data);
     return $data;
 }
?>