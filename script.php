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
    echo "Det finns X trådar:";

    $sql = "SELECT * FROM topics";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
        
    } 

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