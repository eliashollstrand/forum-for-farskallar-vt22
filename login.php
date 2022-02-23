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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php
        session_unset();
    ?>
    <h1>Forum för fårskallar</h1>
    
    <button onclick="showLogin()" class="btn btn-primary" style="margin-top: 20px;">Logga in</button>
    <div id="loginForm" style="display: none; padding-top: 10px">
        <form action="script.php" method="post">
            Användarnamn:<br>
            <input type="text" name="username" style="margin-bottom: 5px">
            <br>
            Lösenord:<br>
            <input type="password" name="password">
            <br>
            <input type="submit" value="Log in" style="margin-top: 5px" class="btn btn-secondary">
        </form>     
    </div><br> 
    <p style="margin-top: 50px;">Har du inte något konto?</p>
    <a href="signup.html">
        <button class="btn btn-primary">Sign up</button>
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