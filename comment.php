<?php
    session_start();

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

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


    $exists = false;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $subs = explode(",", $row["subscriptions"]);
        for($i = 0; $i < count($subs); $i++) {
            // echo strlen(substr($subs[$i], 1));
            if(substr($subs[$i], 1) == $topic) {
                
                if($row["username"] == $user) {
                    $exists = true;
                }

                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = 1;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'forumforfarskallar@gmail.com';                     //SMTP username
                    $mail->Password   = 'farskalle123';                               //SMTP password
                    $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipient
                    $mail->setFrom('forumforfarskallar@gmail.com', 'Forum för fårskallar');
                    $mail->addAddress($row["email"]);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = "Nya kommentarer i tråden $topic!";
                    $mail->Body    = "Det finns nya kommentarer i tråden $topic!";
                    $mail->AltBody = "Det finns nya kommentarer i tråden $topic!";

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    } 

    if($subscribe == "ok" && $exists == false) {
        $sql = "UPDATE users SET subscriptions = CONCAT(subscriptions, ' ', '$topic,') WHERE username = '$user';";
        $result = $conn->query($sql);
    }

    header("Location: http://localhost/forum-for-farskallar/readtopic.php?topic=$topic&op=$op");
?>