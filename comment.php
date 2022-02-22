<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "forum-for-farskallar";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }   
    
    $topic = $_POST["topic"];
    $user = $_SESSION["user"];
    $content = $_POST["content"];
    $subscribe = $_POST["subscribe"];
    $op = "";

    $sql = "SELECT topic FROM topics WHERE topic = '$topic'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $op = $row["op"];
        echo $op;
    } 
    
    $time = date('Y-m-d H:i:s');
    $sql = "INSERT INTO posts (content, topic, user, creationTime) VALUES ('$content', '$topic', '$user', '$time')";
    $result = $conn->query($sql);

    header("Location: http://localhost/forum-for-farskallar/readtopic.php?topic=$topic&op=$op");
?>