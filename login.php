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
<body>
    <?php
        session_unset();
    ?>
    <h1>Forum för fårskallar</h1>
    
    <button onclick="showLogin()">Log in</button>
    <div id="loginForm" style="display: none; padding-top: 10px">
        <form action="script.php" method="post">
            Username:<br>
            <input type="text" name="username" style="margin-bottom: 5px">
            <br>
            Password:<br>
            <input type="password" name="password">
            <br>
            <input type="submit" value="Submit" style="margin-top: 5px">
        </form>     
    </div><br> 
    <p style="margin-top: 50px;">Don't have an account?</p>
    <a href="signup.html">
        <button>Sign up</button>
     </a>

    <script>
        function showLogin() {
            var x = document.getElementById("loginForm");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
</body>
</html>