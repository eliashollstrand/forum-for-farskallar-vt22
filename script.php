<?php
session_start();
?>
<!DOCTYPE html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<style>
    body {
        padding: 20px;
    }
</style>
</head>
<html>
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

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$login_success = false;
// Kontrollera login
if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    $login_success = true;
    $user = $_SESSION['user'];
}
elseif(isset($_SESSION["logged_in"]) == false && isset($_POST["username"])) {
    $name = "";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row["username"] == $_POST["username"] && $row["password"] == $_POST["password"]) {
                $login_success = true;
                $_SESSION["logged_in"] = true;
                $name = $row["username"];
                $_SESSION["user"] = $name;
            }
        } 
    } else {
        echo "0 results";
    }
}

if($login_success) {
    $name = $_SESSION["user"];
    echo "<h1>Forum för fårskallar</h1>";
    echo "Välkommen " . $name . "!<br><br>";
    echo "<a href='addtopic.php'><button style='margin-bottom: 50px;' class='btn btn-secondary'>Skapa tråd</button></a><br>";

    $sql = "SELECT COUNT(*) as num_posts FROM topics";
    $result = $conn->query($sql);

    $num_posts = "";
    while ($row = $result->fetch_assoc()) {
        $num_posts = $row["num_posts"];
    }

    echo "Det finns $num_posts trådar:";

    $html = file_get_contents("templates/threads.html");
    $text_array = explode("***PHP***", $html);

    $sql_topics = "SELECT * FROM topics ORDER BY creationTime DESC";
    $topics_result = $conn->query($sql_topics);
    $sql_posts = "SELECT * FROM posts ORDER BY creationTime DESC";
    $posts_result = $conn->query($sql_posts);
    $topics = [];
    $latest_updates = [];
    while($row = $posts_result->fetch_assoc()) {
        if(!in_array($row["topic"], $topics)) {
            array_push($topics, $row["topic"]);
            array_push($latest_updates, $row["creationTime"]);
        }
    } 

    $i = 0;
    while($row = $topics_result->fetch_assoc()) {

        echo $text_array[0];

        $text = str_replace("***topic***", $row["topic"], $text_array[1]);
        $text = str_replace("***op***", $row["op"], $text);
        $text = str_replace("***time***", $latest_updates[$i], $text);

        echo $text;  
        $i += 1; 
    } 

    echo $text_array[2];

    echo "<br><a href='login.php'>
            <button style='font-size: 10px; box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;' class='btn btn-light'>Logga ut</button>
            </a>";

} else {
    echo "Felaktiga inloggningsuppgifter!";
    echo "<br><a href='login.php'>
            <button class='btn btn-light>Tillbaka till logga in</button>
            </a>";
}
$conn->close();
?>

</html>
</body>