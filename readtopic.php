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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<style>
    body {
        padding: 20px;
    }
    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }
    tr.result:nth-child(odd) {
        background-color: white;
    }
    #likeBtn {
        background: none;
        border: none;
        cursor: pointer;
        margin-left: 20px;
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
            <button class='btn btn-secondary'>Tillbaka till trådarna</button>
            </a>";

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "forum-for-farskallar";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        if(!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }   

        echo "<br><br><h2 style='display: inline-block;'>" . $topic . "</h2>";

        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $likes = explode(",", $row["liked"]);
            if($row["username"] == $user) {
                if(in_array($topic, $likes)) {
                    echo "<button id='likeBtn' class='fa fa-heart' 
                            onclick=\"like('" . $user. "', '".$topic."');\"></button>";
                    break;
                } 
                else {
                    echo "<button id='likeBtn' class='fa fa-heart-o' 
                            onclick=\"like('" . $user. "', '".$topic."');\"></button>";
                    break;
                }
            }

        } 

        echo "<p>Denna tråd startades av <strong>" . $op . "</strong></p>";

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
        echo "Inte inloggad<br>";
        echo "<a href='login.php'>
            <button class='btn btn-secondary'>Tillbaka till log in</button>
            </a>";
    }
?>
<script>
    function like(user, liked) 
    {
        $.ajax({
            url: "like.php",
            type: "POST",
            data: {'username': user, 'liked': liked},                   
            success: function(data) {
                document.getElementById("likeBtn").className = data;
            }
        });
    }
</script>
</body>
</html>