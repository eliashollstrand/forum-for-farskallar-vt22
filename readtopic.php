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
<style>
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }

    tr.result:nth-child(odd) {
        background-color: white;
    }
</style>
<body>

<h1>Forum för fårskallar</h1>

<?php
    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
        $user = $_SESSION['user'];

        $url = "http://";   
        $url.= $_SERVER['HTTP_HOST'];   
        $url.= $_SERVER['REQUEST_URI'];    

        $topic = "";
        if(isset($_POST["topic"])) {
            $topic = $_POST["topic"];
        } else {
            $topic = $_GET["topic"];
        }

        $op = "";
        if(isset($_POST["op"])) {
            $op = $_POST["op"];
        } else {
            $op = $_GET["op"];
        }

        echo "Inloggad som $user <br>";
        echo "<br><a href='script.php'>
            <button>Back to posts</button>
            </a>";
        echo "<br><h2>" . $topic . "</h2>";
        echo "<p><strong>Denna tråd startades av " . $op . "</strong></p>";

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "forum-for-farskallar";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        if(!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }   

        $sql = "SELECT * FROM posts WHERE topic = '$topic'";
        $result = $conn->query($sql);

        $html = file_get_contents("templates/posts.html");
        $text_array = explode("***PHP***", $html); 
        
        echo $text_array[0];
        while($row = $result->fetch_assoc()) {

            $text = str_replace("***user***", $row["user"], $text_array[1]);
            $text = str_replace("***time***", $row["creationTime"], $text);
            $text = str_replace("***content***", $row["content"], $text);

            echo $text;  
        } 
        $text = str_replace("***topic***", $topic, $text_array[2]);
        $text = str_replace("***user***", $user, $text);
        echo $text;
    }
    else {
        echo "Not logged in<br>";
        echo "<a href='login.php'>
            <button>Back to log in</button>
            </a>";
    }
?>

</body>
</html>