<?php
session_start();
?>
<!DOCTYPE html>
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
    echo "<a href='addtopic.php'><button style='margin-bottom: 50px;'>Skapa tråd</button></a><br>";

    $sql = "SELECT COUNT(*) as num_posts FROM topics";
    $result = $conn->query($sql);

    $num_posts = "";
    while ($row = $result->fetch_assoc()) {
        $num_posts = $row["num_posts"];
    }

    echo "Det finns $num_posts trådar:";

    $sql = "SELECT * FROM topics ORDER BY creationTime DESC";
    $result = $conn->query($sql);

    $html = file_get_contents("templates/threads.html");
    $text_array = explode("***PHP***", $html);

    
    while($row = $result->fetch_assoc()) {
        echo $text_array[0];

        $text = str_replace("***topic***", $row["topic"], $text_array[1]);
        $text = str_replace("***op***", $row["op"], $text);
        $text = str_replace("***time***", $row["creationTime"], $text);

        echo $text;  
    } 
    echo $text_array[2];

    echo "<br><a href='login.php'>
            <button>Log out</button>
            </a>";

} else {
    echo "Incorrect login credentials";
    echo "<br><a href='login.php'>
            <button>Back to log in</button>
            </a>";
}
$conn->close();
?>

</html>
</body>