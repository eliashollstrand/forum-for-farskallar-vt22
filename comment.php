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

    $sql = "SELECT * FROM topics WHERE topic = '$topic'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $op = $row["op"];
    } 
    
    $time = date('Y-m-d H:i:s');
    $sql = "INSERT INTO posts (content, topic, user, creationTime) VALUES ('$content', '$topic', '$user', '$time')";
    $result = $conn->query($sql);


    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $subs = explode(",", $row["subscriptions"]);
        for($i = 0; $i < count($subs); $i++) {
            echo $subs[$i];
            if($subs[$i] == $topic) {
                $msg = "Det finns nya kommentarer i tråden $topic!";
                $msg = wordwrap($msg, 70);
                mail($row['email'], "Forum för fårskallar - Ny kommentar", $msg);
                break;
            }
        }
    } 

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $count = 0;
    while($row = $result->fetch_assoc()) {
        $subs = explode(",", preg_replace('/' . " " . '/', "", $row["subscriptions"]), 1);
        for($i = 0; $i < count($subs); $i++) {
            echo "Hej";
            echo $subs[$i];
            echo $topic;
            if($subs[$i] == $topic) {
                $count += 1;
            }
        }
    } 
    echo $count;

    if($subscribe == "ok" && $count == 0) {
        $sql = "UPDATE users SET subscriptions = CONCAT(subscriptions, ' ', '$topic,') WHERE username = '$user';";
        $result = $conn->query($sql);
    }

    // header("Location: http://localhost/forum-for-farskallar/readtopic.php?topic=$topic&op=$op");
?>