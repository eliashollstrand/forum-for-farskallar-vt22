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

$header = $_POST["header"];
$op = $_SESSION["user"];
$content = $_POST["content"];
$subscribe = $_POST["subscribe"];

$sql = "SELECT topic FROM topics WHERE topic = '$header'";
$result = $conn->query($sql);
if ($result !== false && $result->num_rows > 0) {
    echo "A topic with that name already exists!<br>";
    echo "<a href='addtopic.php'>
            <button>Add other topic</button>
            </a>";
    echo "<a href='showtopic.php'>
            <button>Go to $header</button>
            </a>";

} else {
    $sql = "INSERT INTO topics (op, topic) VALUES ('$op', '$header')";
    $result = $conn->query($sql);

    $sql = "INSERT INTO posts (content, topic) VALUES ('$content', '$header')";
    $result = $conn->query($sql);

    header("Location: http://localhost/forum-for-farskallar/script.php");
}
?>

</body>
</html>