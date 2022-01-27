<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forum-for-farskallar";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST["name"];
$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * from users where username = '$username'";
$result = $conn->query($sql);

if($result->num_rows == 0) {
    $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";
    $result = $conn->query($sql);

    header("Location: login.html");
    die();
} else {
    echo "Username already taken<br>";
    echo "<a href='signup.html'>
    <button style='margin-top: 10px;'>Go back</button>
 </a>";

}

?>

</body>
</html>