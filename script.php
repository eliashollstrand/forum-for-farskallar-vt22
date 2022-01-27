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
$name = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		if($row["username"] == $_POST["username"] && $row["password"] == $_POST["password"]) {
			$login_success = true;
			$name = $row["username"];
            $_SESSION["user"] = $name;
            
	    }
    } 
} else {
    echo "0 results";
}

if($login_success) {
    echo "<h1>Forum för fårskallar</h1>";
    echo "Welcome " . $name . "!<br><br>";
    echo "<button style='margin-bottom: 50px;'>Skapa tråd</button><br>"; 
    echo "Det finns X trådar:";


} else {
    echo "Incorrect login credentials";
}
$conn->close();
?>

</html>
</body>