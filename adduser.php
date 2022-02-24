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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        body {
            padding: 20px;
        }
    </style>
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

$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * from users where username = '$username'";
$result = $conn->query($sql);

if($result->num_rows == 0) {
    $sql = "INSERT INTO users (email, username, password, subscriptions) VALUES ('$email', '$username', '$password', '')";
    $result = $conn->query($sql);

    header("Location: login.php");
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