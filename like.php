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

function fillLikeBtn($fill) {
    if($fill) {
        echo 'fa fa-heart';
    } else {
        echo 'fa fa-heart-o';
    }
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    $likes = explode(",", $row["liked"]);
    if($row["username"] == $user) {
        if(in_array($liked, $likes)) {
            $sql = "UPDATE users SET liked = REPLACE(liked, '$liked,', '') WHERE username = '$user';";
            $result = $conn->query($sql);
            fillLikeBtn(false);
            break;
        } 
        else {
            $sql = "UPDATE users SET liked = CONCAT(liked, '$liked,') WHERE username = '$user';";
            $result = $conn->query($sql);
            fillLikeBtn(true);
            break;
        }
    }

} 

?>