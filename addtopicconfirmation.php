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
    $time = date('Y-m-d H:i:s');
    $sql = "INSERT INTO topics (op, topic, creationTime) VALUES ('$op', '$header', '$time')";
    $result = $conn->query($sql);

    $sql = "INSERT INTO posts (content, topic, user, creationTime) VALUES ('$content', '$header', '$op', '$time')";
    $result = $conn->query($sql);
    
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $count = 0;
    while($row = $result->fetch_assoc()) {
        $subs = explode(",", $row["subscriptions"]);
        for($i = 0; $i < count($subs); $i++) {
            if($subs[$i] == $topic) {
                $count += 1;
            }
        }
    } 
    
    if($subscribe == "ok" && $count == 0) {
        $sql = "UPDATE users SET subscriptions = CONCAT(subscriptions, ' ', '$header,') WHERE username = '$op';";
        $result = $conn->query($sql);
    }

    header("Location: http://localhost/forum-for-farskallar/script.php");
}
?>

</body>
</html>