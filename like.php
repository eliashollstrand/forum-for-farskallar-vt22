<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forum-for-farskallar";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}   

$user = $_POST['username'];
$liked = $_POST['liked'];  

$sql = "UPDATE users SET liked = CONCAT(liked, ' ', '$liked,') WHERE username = '$user';";
$result = $conn->query($sql);

mysqli_close($conn);
?>